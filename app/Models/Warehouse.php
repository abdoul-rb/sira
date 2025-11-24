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
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([TenantScope::class])]
class Warehouse extends Model
{
    /** @use HasFactory<\Database\Factories\WarehouseFactory> */
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'location',
        'default',
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Un entrepôt peut contenir plusieurs produits.
     */
    public function warehouseProducts(): HasMany
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #[Scope]
    protected function scopeDefault(Builder $query): void
    {
        $query->where('default', true);
    }

    #[Scope]
    protected function scopeForCompany(Builder $query, int $companyId): void
    {
        $query->where('company_id', $companyId);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Récupère le stock d'un produit dans cet entrepôt
     */
    public function getProductStock(Product $product): int
    {
        $warehouseProduct = $this->warehouseProducts()
            ->where('product_id', $product->id)
            ->first();

        return $warehouseProduct ? $warehouseProduct->quantity : 0;
    }

    /**
     * Met à jour le stock d'un produit dans cet entrepôt
     */
    public function updateProductStock(Product $product, int $quantity): void
    {
        $this->warehouseProducts()->updateOrCreate(
            ['product_id' => $product->id],
            ['quantity' => $quantity]
        );

        // Recalculer le stock total du produit
        $product->recalculateTotalStock();
    }

    /**
     * Décrémente le stock d'un produit dans cet entrepôt
     */
    public function decreaseProductStock(Product $product, int $quantity): bool
    {
        $warehouseProduct = $this->warehouseProducts()
            ->where('product_id', $product->id)
            ->first();

        if (! $warehouseProduct || $warehouseProduct->quantity < $quantity) {
            return false; // Stock insuffisant
        }

        $warehouseProduct->decrement('quantity', $quantity);

        // Recalculer le stock total du produit
        $product->recalculateTotalStock();

        return true;
    }

    /**
     * Vérifie si un produit a suffisamment de stock dans cet entrepôt
     */
    public function hasSufficientStock(Product $product, int $quantity): bool
    {
        return $this->getProductStock($product) >= $quantity;
    }

    /**
     * Marque cet entrepôt comme entrepôt par défaut pour l'entreprise
     */
    public function markAsDefault(): void
    {
        // D'abord, retirer le statut par défaut des autres entrepôts de la même entreprise
        static::where('company_id', $this->company_id)
            ->where('id', '!=', $this->id)
            ->update(['default' => false]);

        // Puis marquer celui-ci comme par défaut
        $this->update(['default' => true]);
    }
}
