<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function quotations(): BelongsToMany
    {
        return $this->belongsToMany(Quotation::class, 'product_quotation')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps();
    }

    public function warehouseProducts(): HasMany
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function getProfitMarginAttribute(): float
    {
        if (! $this->cost_price || $this->cost_price == 0) {
            return 0;
        }

        return (($this->price - $this->cost_price) / $this->cost_price) * 100;
    }

    public function updateStock(int $quantity): void
    {
        $this->increment('stock_quantity', $quantity);
    }

    public function decreaseStock(int $quantity): void
    {
        $this->decrement('stock_quantity', $quantity);
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

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
