<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Products;

use App\Actions\Product\CreateAction as ProductAction;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Company;
use App\Traits\ManagesProductWarehouses;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use ManagesProductWarehouses;
    use WithFileUploads;

    public Company $tenant;

    public string $name = '';

    public string $description = '';

    public ?UploadedFile $featuredImage = null;

    public ?int $price = null;

    public ?int $stockQuantity = null;

    public ?string $sku = null;

    // Propriétés pour les entrepôts
    public array $warehouseLines = [];

    public int $totalWarehouseQuantity = 0;

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

        // Vérifier que le total des quantités assignées correspond au stockQuantity
        $this->calculateTotalWarehouseQuantity();

        /* if ($this->totalWarehouseQuantity !== (int) $this->stockQuantity) {
            $this->addError('stockQuantity', "La quantité globale ({$this->stockQuantity}) doit correspondre au total des quantités assignées aux entrepôts ({$this->totalWarehouseQuantity}).");
            return;
        } */

        $product = $action->handle($this->tenant, $validated);

        // Assigner les quantités aux entrepôts
        $this->syncQuantitiesToWarehouses($product);

        $this->dispatch('close-modal', id: 'create-product');
        $this->dispatch('product-created');

        $this->reset(['name', 'description', 'featuredImage', 'price', 'stockQuantity', 'warehouseLines', 'totalWarehouseQuantity']);
    }

    public function render()
    {
        $warehouses = $this->tenant->warehouses()->orderBy('name')->get();

        return view('livewire.dashboard.products.create', [
            'warehouses' => $warehouses,
        ]);
    }
}
