<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Product;

use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Company;
use App\Models\Warehouse;
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

    public $warehouse_id = '';

    public $warehouse_quantity = '';

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
        
        $this->selectDefaultWarehouse();
    }

    /** Sélectionne l'entrepôt par défaut ou le premier entrepôt si aucun par défaut */
    private function selectDefaultWarehouse()
    {
        $defaultWarehouse = $this->tenant->warehouses()->default()->first();

        if ($defaultWarehouse) {
            $this->warehouse_id = $defaultWarehouse->id;
        } else {
            // Si pas d'entrepôt par défaut, prendre le premier
            $firstWarehouse = $this->tenant->warehouses()->first();
            
            if ($firstWarehouse) {
                $this->warehouse_id = $firstWarehouse->id;
            }
        }
    }

    public function save()
    {
        $this->validate();

        $product = $this->tenant->products()->create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => 0, // Sera recalculé automatiquement
        ]);

        if ($this->featured_image) {
            $filename = $this->featured_image->getClientOriginalName();
            $path = "{$this->tenant->id}/products/";
            $imagePath = "{$path}/{$filename}";
            
            $this->featured_image->storeAs($path, $filename, 'public');
            $product->update(['featured_image' => $imagePath]);
        }

        $warehouse = Warehouse::find($this->warehouse_id);
        $warehouse->updateProductStock($product, (int) $this->warehouse_quantity);

        $this->dispatch('close-modal', id: 'create-product');
        $this->dispatch('product-created');

        $this->reset(['name', 'description', 'featured_image', 'price', 'warehouse_id', 'warehouse_quantity']);
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
