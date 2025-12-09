<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\QuotationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Quotation extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'customer_id',
        'reference',
        'status',
        'subtotal',
        'tax_amount',
        'total_amount',
        'notes',
        'valid_until',
        'sent_at',
        'accepted_at',
        'rejected_at',
    ];

    protected $casts = [
        'status' => QuotationStatus::class,
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'valid_until' => 'datetime',
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Quotation $quotation) {
            $quotation->reference = Str::uuid();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the company associated with the quotation.
     *
     * @return BelongsTo<Company, Quotation>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the customer associated with the quotation.
     *
     * @return BelongsTo<Customer, Quotation>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the products associated with the quotation.
     *
     * @return BelongsToMany<Product, Quotation, Pivot>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_quotation')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get the orders associated with the quotation.
     *
     * @return HasMany<Order, Quotation>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeDraft(Builder $query): void
    {
        $query->where('status', QuotationStatus::DRAFT);
    }

    public function scopeSent(Builder $query): void
    {
        $query->where('status', QuotationStatus::SENT);
    }

    public function scopeAccepted(Builder $query): void
    {
        $query->where('status', QuotationStatus::ACCEPTED);
    }

    public function scopeRejected(Builder $query): void
    {
        $query->where('status', QuotationStatus::REJECTED);
    }

    public function scopeExpired(Builder $query): void
    {
        $query->where('status', QuotationStatus::EXPIRED);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Mark the quotation as sent.
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => QuotationStatus::SENT,
            'sent_at' => now(),
        ]);
    }

    /**
     * Mark the quotation as accepted.
     */
    public function markAsAccepted(): void
    {
        $this->update([
            'status' => QuotationStatus::ACCEPTED,
            'accepted_at' => now(),
        ]);
    }

    /**
     * Mark the quotation as rejected.
     */
    public function markAsRejected(): void
    {
        $this->update([
            'status' => QuotationStatus::REJECTED,
            'rejected_at' => now(),
        ]);
    }

    /**
     * Mark the quotation as expired.
     */
    public function markAsExpired(): void
    {
        $this->update([
            'status' => QuotationStatus::EXPIRED,
        ]);
    }

    /**
     * Check if the quotation is expired.
     */
    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    /**
     * Check if the quotation can be converted to an order.
     */
    public function canBeConvertedToOrder(): bool
    {
        return $this->status === QuotationStatus::ACCEPTED;
    }

    /**
     * Calculate the totals for the quotation.
     */
    public function calculateTotals(): void
    {
        $subtotal = $this->products->sum(function ($product) {
            return $product->pivot->total_price;
        });

        $taxAmount = $this->tax_amount ?? 0;

        $this->update([
            'subtotal' => $subtotal,
            'total_amount' => $subtotal + $taxAmount,
        ]);
    }
}
