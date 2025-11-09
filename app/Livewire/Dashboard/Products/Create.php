<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Products;

use App\Actions\Product\CreateAction as ProductAction;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Company;
use App\Traits\ManagesProductWarehouses;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    use ManagesProductWarehouses;

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
    public function refreshWarehouses()
    {
        // Liste des entrepôt
    }

    public function save(ProductAction $action)
    {
        $validated = $this->validate();

        // Vérifier que le total des quantités assignées correspond au stock_quantity
        $this->calculateTotalWarehouseQuantity();
        
        /* if ($this->totalWarehouseQuantity !== (int) $this->stock_quantity) {
            $this->addError('stock_quantity', "La quantité globale ({$this->stock_quantity}) doit correspondre au total des quantités assignées aux entrepôts ({$this->totalWarehouseQuantity}).");
            return;
        } */

        $product = $action->handle($this->tenant, $validated);

        // Assigner les quantités aux entrepôts
        $this->syncQuantitiesToWarehouses($product);

        $this->dispatch('close-modal', id: 'create-product');
        $this->dispatch('product-created');

        $this->reset(['name', 'description', 'featured_image', 'price', 'stock_quantity', 'warehouseLines', 'totalWarehouseQuantity']);
    }

    public function render()
    {
        $warehouses = $this->tenant->warehouses()->orderBy('name')->get();
        
        return view('livewire.dashboard.products.create', [
            'warehouses' => $warehouses,
        ]);
    }
}
