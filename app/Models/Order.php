<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Services\OrderNumberService;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Number;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([TenantScope::class])]
class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'customer_id',
        'warehouse_id',
        'order_number',
        'status',
        'subtotal',
        'discount',
        'advance',
        'payment_status',
        'total_amount',
        'paid_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'advance' => 'decimal:2',
        'payment_status' => PaymentStatus::class,
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Order $order) {
            // Génération du numéro de commande avec le nouveau service
            $orderNumberService = app(OrderNumberService::class);
            $order->order_number = $orderNumberService->generate($order->company);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Get the user's total amount.
     */
    protected function totalAmount(): Attribute
    {
        return Attribute::make(
            get: fn (float $value) => Number::currency($value, in: 'XOF', locale: 'fr'),
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * L'entreprise tenante
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Le client qui à passer la commande
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Le items produits de la commande
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
        /* return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps(); */
    }

    /**
     * L'entrepôt d'où la commande est pris
     *
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #[Scope]
    public function pending(Builder $query): void
    {
        $query->where('status', OrderStatus::PENDING);
    }

    #[Scope]
    public function paid(Builder $query): void
    {
        $query->where('status', OrderStatus::PAID);
    }

    #[Scope]
    public function delivered(Builder $query): void
    {
        $query->where('status', OrderStatus::DELIVERED);
    }

    #[Scope]
    public function cancelled(Builder $query): void
    {
        $query->where('status', OrderStatus::CANCELLED);
    }

    /**
     * Scope a query to only include popular users.
     */
    #[Scope]
    protected function credit(Builder $query): void
    {
        $query->where('payment_status', PaymentStatus::CREDIT);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function markAsPaid(): void
    {
        $this->update([
            'status' => OrderStatus::PAID,
            'paid_at' => now(),
        ]);
    }

    public function markAsDelivered(): void
    {
        $this->update([
            'status' => OrderStatus::DELIVERED,
            'delivered_at' => now(),
        ]);
    }

    public function markAsCancelled(): void
    {
        $this->update([
            'status' => OrderStatus::CANCELLED,
            'cancelled_at' => now(),
        ]);
    }

    public function calculateTotals(): void
    {
        $subtotal = $this->products->sum(function ($product) {
            return $product->pivot->total_price;
        });

        $discount = $this->discount ?? 0;

        $this->update([
            'subtotal' => $subtotal,
            'total_amount' => $subtotal - $discount,
        ]);
    }

    public function canBeShipped(): bool
    {
        return in_array($this->status, [
            OrderStatus::PAID,
        ]);
    }

    public function canBeDelivered(): bool
    {
        return $this->status === OrderStatus::PAID;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [
            OrderStatus::PENDING,
            OrderStatus::PAID,
        ]);
    }

    /**
     * Décrémente les stocks de tous les produits de la commande dans l'entrepôt sélectionné
     */
    public function decreaseStocks(): bool
    {
        if (! $this->warehouse) {
            return false; // Pas d'entrepôt sélectionné
        }

        // @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
        foreach ($this->products as $item) {
            $quantity = $item->quantity;

            // @var \App\Models\Product $product
            if (! $this->warehouse->hasSufficientStock($item->product, $quantity)) {
                return false; // Stock insuffisant pour au moins un produit
            }
        }

        // Décrémenter les stocks de tous les produits
        foreach ($this->products as $item) {
            $quantity = $item->pivot->quantity;
            $this->warehouse->decreaseProductStock($item->product, $quantity);
        }

        return true;
    }

    /**
     * Vérifie si tous les produits de la commande ont suffisamment de stock dans l'entrepôt sélectionné
     */
    public function canFulfillFromWarehouse(): bool
    {
        if (! $this->warehouse) {
            return false;
        }

        foreach ($this->products as $item) {
            $quantity = $item->quantity;

            if (! $this->warehouse->hasSufficientStock($item->product, $quantity)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calcule le montant restant à payer
     */
    public function getRemainingAmountAttribute(): float
    {
        return $this->total_amount - $this->advance;
    }

    /**
     * Vérifie si la commande est entièrement payée
     */
    public function isFullyPaid(): bool
    {
        return $this->advance >= $this->total_amount;
    }

    /**
     * Vérifie si la commande est partiellement payée
     */
    public function isPartiallyPaid(): bool
    {
        return $this->advance > 0 && $this->advance < $this->total_amount;
    }

    /**
     * Vérifie si la commande n'est pas payée
     */
    public function isUnpaid(): bool
    {
        return $this->advance == 0;
    }
}
