<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[ScopedBy([TenantScope::class])]
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'description',
        'featured_image',
        'sku',
        'price',
        'stock_quantity',
    ];

    protected $casts = [
        'price' => 'float',
        'stock_quantity' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the company associated with the product.
     *
     * @return BelongsTo<Company, Product>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the quotations associated with the product.
     *
     * @return BelongsToMany<Quotation, Product>
     */
    public function quotations(): BelongsToMany
    {
        return $this->belongsToMany(Quotation::class, 'product_quotation')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get the orders associated with the product.
     *
     * @return BelongsToMany<Order, Product>
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get the order items associated with the product.
     *
     * @return HasMany<OrderProduct, Product>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Un produit peut être présent dans plusieurs entrepôts.
     *
     * @return HasMany<WarehouseProduct, Product>
     */
    public function warehouseProducts(): HasMany
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #[Scope]
    protected function inStock(Builder $query): void
    {
        $query->where('stock_quantity', '>', 0);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the profit margin of the product.
     *
     * @return float|int
     */
    public function getProfitMarginAttribute(): float
    {
        if (! $this->cost_price || $this->cost_price == 0) {
            return 0;
        }

        return (($this->price - $this->cost_price) / $this->cost_price) * 100;
    }

    /**
     * Update the stock quantity of the product.
     */
    public function updateStock(int $quantity): void
    {
        $this->increment('stock_quantity', $quantity);
    }

    /**
     * Decrease the stock quantity of the product.
     */
    public function decreaseStock(int $quantity): void
    {
        $this->decrement('stock_quantity', $quantity);
    }

    /**
     * Check if the product is in stock.
     */
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Check if the product has sufficient stock.
     */
    public function hasSufficientStock(int $quantity): bool
    {
        return $this->stock_quantity >= $quantity;
    }

    /**
     * Recalcule et met à jour le stock total basé sur les quantités dans tous les entrepôts
     */
    public function recalculateTotalStock(): void
    {
        $totalStock = $this->warehouseProducts()->sum('quantity');
        $this->update(['stock_quantity' => $totalStock]);
    }

    /**
     * Récupère le stock d'un produit dans un entrepôt spécifique
     */
    public function getStockInWarehouse(Warehouse $warehouse): int
    {
        return $warehouse->getProductStock($this);
    }

    /**
     * Vérifie si le produit a suffisamment de stock dans un entrepôt spécifique
     */
    public function hasSufficientStockInWarehouse(Warehouse $warehouse, int $quantity): bool
    {
        return $warehouse->hasSufficientStock($this, $quantity);
    }
}
