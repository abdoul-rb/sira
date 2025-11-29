<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Décrémente les stocks d'une commande dans l'entrepôt sélectionné
     */
    public function decreaseOrderStocks(Order $order): bool
    {
        if (! $order->warehouse) {
            return false;
        }

        return DB::transaction(function () use ($order) {
            // Vérifier d'abord si tous les produits ont suffisamment de stock
            if (! $this->validateOrderStockAvailability($order)) {
                return false;
            }

            // Décrémenter les stocks
            foreach ($order->productLines as $line) {
                $quantity = $line->quantity;
                if ($line->product) {
                    $this->decreaseProductStock($order->warehouse, $line->product, $quantity);
                }
            }

            return true;
        });
    }

    /**
     * Vérifie si une commande peut être honorée avec les stocks disponibles
     */
    public function validateOrderStockAvailability(Order $order): bool
    {
        if (! $order->warehouse) {
            return false;
        }

        foreach ($order->productLines as $line) {
            $quantity = $line->quantity;
            if ($line->product && ! $this->hasSufficientStock($order->warehouse, $line->product, $quantity)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Décrémente le stock d'un produit dans un entrepôt spécifique
     */
    public function decreaseProductStock(Warehouse $warehouse, Product $product, int $quantity): bool
    {
        return DB::transaction(function () use ($warehouse, $product, $quantity) {
            $warehouseProduct = WarehouseProduct::where('warehouse_id', $warehouse->id)
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            if (! $warehouseProduct || $warehouseProduct->quantity < $quantity) {
                return false;
            }

            $warehouseProduct->decreaseQuantity($quantity);
            $product->recalculateTotalStock();

            return true;
        });
    }

    /**
     * Augmente le stock d'un produit dans un entrepôt spécifique
     */
    public function increaseProductStock(Warehouse $warehouse, Product $product, int $quantity): void
    {
        DB::transaction(function () use ($warehouse, $product, $quantity) {
            WarehouseProduct::updateOrCreate(
                [
                    'warehouse_id' => $warehouse->id,
                    'product_id' => $product->id,
                ],
                [
                    'quantity' => DB::raw("quantity + {$quantity}"),
                ]
            );

            $product->recalculateTotalStock();
        });
    }

    /**
     * Met à jour le stock d'un produit dans un entrepôt spécifique
     */
    public function updateProductStock(Warehouse $warehouse, Product $product, int $quantity): void
    {
        DB::transaction(function () use ($warehouse, $product, $quantity) {
            WarehouseProduct::updateOrCreate(
                [
                    'warehouse_id' => $warehouse->id,
                    'product_id' => $product->id,
                ],
                [
                    'quantity' => $quantity,
                ]
            );

            $product->recalculateTotalStock();
        });
    }

    /**
     * Vérifie si un produit a suffisamment de stock dans un entrepôt
     */
    public function hasSufficientStock(Warehouse $warehouse, Product $product, int $quantity): bool
    {
        $warehouseProduct = WarehouseProduct::where('warehouse_id', $warehouse->id)
            ->where('product_id', $product->id)
            ->first();

        return $warehouseProduct && $warehouseProduct->quantity >= $quantity;
    }

    /**
     * Récupère le stock d'un produit dans un entrepôt spécifique
     */
    public function getProductStockInWarehouse(Warehouse $warehouse, Product $product): int
    {
        $warehouseProduct = WarehouseProduct::where('warehouse_id', $warehouse->id)
            ->where('product_id', $product->id)
            ->first();

        return $warehouseProduct ? $warehouseProduct->quantity : 0;
    }

    /**
     * Récupère le stock total d'un produit dans tous les entrepôts d'une entreprise
     */
    public function getTotalProductStockInCompany(Product $product): int
    {
        return WarehouseProduct::whereHas('warehouse', function ($query) use ($product) {
            $query->where('company_id', $product->company_id);
        })
            ->where('product_id', $product->id)
            ->sum('quantity');
    }

    /**
     * Récupère la répartition du stock d'un produit dans tous les entrepôts
     */
    public function getProductStockDistribution(Product $product): Collection
    {
        return WarehouseProduct::where('product_id', $product->id)
            ->with('warehouse')
            ->get()
            ->map(function ($warehouseProduct) {
                return [
                    'warehouse' => $warehouseProduct->warehouse,
                    'quantity' => $warehouseProduct->quantity,
                ];
            });
    }

    /**
     * Synchronise le stock total d'un produit avec la somme des stocks dans les entrepôts
     */
    public function syncProductTotalStock(Product $product): void
    {
        $totalStock = $this->getTotalProductStockInCompany($product);
        $product->update(['stock_quantity' => $totalStock]);
    }

    /**
     * Synchronise le stock total de tous les produits d'une entreprise
     */
    public function syncAllProductsTotalStock(int $companyId): void
    {
        $products = Product::where('company_id', $companyId)->get();

        foreach ($products as $product) {
            $this->syncProductTotalStock($product);
        }
    }

    /**
     * Récupère les produits en rupture de stock dans un entrepôt
     */
    public function getOutOfStockProductsInWarehouse(Warehouse $warehouse): Collection
    {
        return WarehouseProduct::where('warehouse_id', $warehouse->id)
            ->where('quantity', 0)
            ->with('product')
            ->get()
            ->pluck('product');
    }

    /**
     * Récupère les produits avec un stock faible dans un entrepôt
     */
    public function getLowStockProductsInWarehouse(Warehouse $warehouse, int $threshold = 10): Collection
    {
        return WarehouseProduct::where('warehouse_id', $warehouse->id)
            ->where('quantity', '>', 0)
            ->where('quantity', '<=', $threshold)
            ->with('product')
            ->get()
            ->map(function ($warehouseProduct) {
                return [
                    'product' => $warehouseProduct->product,
                    'quantity' => $warehouseProduct->quantity,
                ];
            });
    }
}
