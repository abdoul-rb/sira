<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Product;
use App\Models\Warehouse;

trait ManagesProductWarehouses
{
    /**
     * Ajouter une nouvelle ligne entrepôt-quantité
     */
    public function addWarehouseLine()
    {
        $defaultWarehouse = $this->tenant->warehouses()->default()->first();
        $firstWarehouse = $this->tenant->warehouses()->first();
        
        $this->warehouseLines[] = [
            'warehouse_id' => $defaultWarehouse ? $defaultWarehouse->id : ($firstWarehouse ? $firstWarehouse->id : null),
            'quantity' => 0,
        ];
    }

    /**
     * Supprimer une ligne entrepôt-quantité 
     *
     * @param [type] $index ()int
     * @return void
     */
    public function removeWarehouseLine($index)
    {
        unset($this->warehouseLines[$index]);
        $this->warehouseLines = array_values($this->warehouseLines);
        $this->calculateTotalWarehouseQuantity();
    }

    /**
     * Mise à jour des lignes entrepôt
     */
    public function updatedWarehouseLines($value, $key)
    {
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
    public function calculateTotalWarehouseQuantity()
    {
        $this->totalWarehouseQuantity = collect($this->warehouseLines)->sum('quantity');
    }

    /**
     * Assigner les quantités aux entrepôts
     *
     * @param Product $product
     * @return void
     */
    private function syncQuantitiesToWarehouses(Product $product)
    {
        foreach ($this->warehouseLines as $line) {
            if (!empty($line['warehouse_id']) && $line['quantity'] > 0) {
                $warehouse = Warehouse::find($line['warehouse_id']);
                
                if ($warehouse) {
                    $warehouse->updateProductStock($product, (int) $line['quantity']);
                }
            }
        }
    }
}
