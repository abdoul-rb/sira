<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Company;

/**
 * @property Company $tenant
 */
trait ManagesProductWarehouses
{
    /**
     * Ajouter une nouvelle ligne entrepôt-quantité
     */
    public function addWarehouseLine(): void
    {
        /** @var Warehouse|null $defaultWarehouse */
        $defaultWarehouse = $this->tenant->warehouses()->default()->first();
        
        /** @var Warehouse|null $firstWarehouse */
        $firstWarehouse = $this->tenant->warehouses()->first();

        $this->warehouseLines[] = [
            'warehouse_id' => $defaultWarehouse ? $defaultWarehouse->id : ($firstWarehouse ? $firstWarehouse->id : null),
            'quantity' => 0,
        ];
    }

    /**
     * Supprimer une ligne entrepôt-quantité
     *
     * @param int $index
     * @return void
     */
    public function removeWarehouseLine(int $index): void
    {
        unset($this->warehouseLines[$index]);
        $this->warehouseLines = array_values($this->warehouseLines);
        $this->calculateTotalWarehouseQuantity();
    }

    /**
     * Mise à jour des lignes entrepôt
     */
    public function updatedWarehouseLines(mixed $value, ?string $key): void
    {
        // Si la clé est null (mise à jour globale) ou ne contient pas de point, on recalcule tout
        if (is_null($key) || ! str_contains($key, '.')) {
            $this->calculateTotalWarehouseQuantity();

            return;
        }

        // Extraire l'index et le champ depuis la clé (ex: "0.quantity")
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        if ($field === 'quantity') {
            $this->calculateTotalWarehouseQuantity();
        }
    }

    /**
     * Calculer le total des quantités assignées aux entrepôts
     */
    public function calculateTotalWarehouseQuantity(): void
    {
        $this->totalWarehouseQuantity = collect($this->warehouseLines)->sum('quantity');
    }

    /**
     * Assigner les quantités aux entrepôts
     *
     * @return void
     */
    private function syncQuantitiesToWarehouses(Product $product): void
    {
        foreach ($this->warehouseLines as $line) {
            if (! empty($line['warehouse_id']) && $line['quantity'] > 0) {
                $warehouse = Warehouse::find($line['warehouse_id']);

                if ($warehouse) {
                    $warehouse->updateProductStock($product, (int) $line['quantity']);
                }
            }
        }
    }
}
