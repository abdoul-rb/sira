<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Product;

use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Company;
use App\Models\Warehouse;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public Company $tenant;

    public $name = '';

    public $description = '';

    public $featured_image;

    public $price = '';

    public $stock_quantity = '';

    // Propriétés pour les entrepôts
    public $warehouseLines = [];
    public $totalWarehouseQuantity = 0;

    protected function rules()
    {
        return (new StoreProductRequest)->rules();
    }

    protected function messages()
    {
        return (new StoreProductRequest)->messages();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Vérifier qu'au moins un entrepôt existe pour cette entreprise
            if ($this->tenant->warehouses()->count() === 0) {
                $validator->errors()->add('warehouse_id', "Aucun entrepôt n'existe pour cette entreprise. Veuillez d'abord créer un entrepôt.");
            }
        });
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
        
        $this->addWarehouseLine(); // Ajouter une première ligne par défaut
        $this->calculateTotalWarehouseQuantity(); // Calculer le total initial
    }

    #[On('warehouse-created')]
    public function refreshSuppliers()
    {
        // Liste des entrepôt
    }

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
     */
    public function removeWarehouseLine($index)
    {
        unset($this->warehouseLines[$index]);
        $this->warehouseLines = array_values($this->warehouseLines); // Réindexer
        $this->calculateTotalWarehouseQuantity();
    }

    /**
     * Calculer le total des quantités assignées aux entrepôts
     */
    public function calculateTotalWarehouseQuantity()
    {
        $this->totalWarehouseQuantity = collect($this->warehouseLines)->sum('quantity');
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

    public function save()
    {
        $this->validate();

        // Vérifier que le total des quantités assignées correspond au stock_quantity
        $this->calculateTotalWarehouseQuantity();
        
        /* if ($this->totalWarehouseQuantity !== (int) $this->stock_quantity) {
            $this->addError('stock_quantity', "La quantité globale ({$this->stock_quantity}) doit correspondre au total des quantités assignées aux entrepôts ({$this->totalWarehouseQuantity}).");
            return;
        } */

        $product = $this->tenant->products()->create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
        ]);

        if ($this->featured_image) {
            $filename = $this->featured_image->getClientOriginalName();
            $path = "{$this->tenant->id}/products/";
            $imagePath = "{$path}/{$filename}";
            
            $this->featured_image->storeAs($path, $filename, 'public');
            $product->update(['featured_image' => $imagePath]);
        }

        // Assigner les quantités aux entrepôts
        $this->assignQuantitiesToWarehouses($product);

        $this->dispatch('close-modal', id: 'create-product');
        $this->dispatch('product-created');

        $this->reset(['name', 'description', 'featured_image', 'price', 'stock_quantity', 'warehouseLines', 'totalWarehouseQuantity']);
    }

    /**
     * Assigner les quantités aux entrepôts
     */
    private function assignQuantitiesToWarehouses(\App\Models\Product $product)
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

    public function render()
    {
        $warehouses = $this->tenant->warehouses()->orderBy('name')->get();
        
        return view('livewire.dashboard.product.create', [
            'tenant' => $this->tenant,
            'warehouses' => $warehouses,
        ]);
    }
}
