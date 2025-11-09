<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Products;

use App\Actions\Product\EditAction as ProductAction;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Company;
use App\Models\Product;
use App\Models\WarehouseProduct;
use App\Traits\ManagesProductWarehouses;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use ManagesProductWarehouses;

    public Company $tenant;

    public Product $product;

    public string $name = '';

    public string $description = '';

    public ?UploadedFile $featuredImage = null;

    public ?string $currentImagePath = null;

    public ?string $sku = null;

    public string $price = '';

    public string $stockQuantity = '';

    public array $warehouseLines = [];
    
    public int $totalWarehouseQuantity = 0;

    protected function rules()
    {
        return (new UpdateProductRequest)->rules();
    }

    protected function messages()
    {
        return (new UpdateProductRequest)->messages();
    }

    public function mount()
    {
        $this->tenant = Auth::user()->member->company;
    }

    #[On('open-edit-product-modal')]
    public function loadCurrentProduct(int $productId)
    {
        $this->product = Product::findOrFail($productId);
        $this->tenant = $this->product->company;

        $this->fill([
            'product' => $this->product,
            'name' => $this->product->name,
            'description' => $this->product->description,
            'sku' => $this->product->sku,
            'price' => $this->product->price,
            'stockQuantity' => $this->product->stock_quantity,
        ]);

        $this->currentImagePath = $this->product->featured_image
            ? Storage::disk('public')->url($this->product->featured_image)
            : null;

        $this->warehouseLines = $this->product->warehouseProducts
            ->map(fn (WarehouseProduct $item) => [
                'warehouse_id' => $item->warehouse_id,
                'quantity' => $item->quantity
            ])
            ->toArray();

        if (empty($this->warehouseLines)) {
            $this->addWarehouseLine();
        }

        $this->calculateTotalWarehouseQuantity();

        $this->dispatch('open-modal', id: 'edit-product');
    }

    public function removeFeaturedImage()
    {
        if ($this->product && $this->product->featured_image) {
            Storage::disk('public')->delete($this->product->featured_image);
            $this->product->update(['featured_image' => null]);
        }
    
        $this->currentImagePath = null;
    }

    public function update(ProductAction $action)
    {
        $validated = $this->validate();

        $this->calculateTotalWarehouseQuantity();

        $this->product = $action->handle($this->product, $validated);

        // Supprimer les lignes existantes pour repartir propre
        $this->product->warehouseProducts()->delete();

        $this->syncQuantitiesToWarehouses($this->product);

        $this->dispatch('product-updated');
        $this->dispatch('notify', 'Produit mis à jour avec succès !');

        $this->reset(['name', 'description', 'featuredImage', 'price', 'stockQuantity', 'warehouseLines', 'totalWarehouseQuantity']);
        
        $this->dispatch('close-modal', id: 'edit-product');
    }

    public function render()
    {
        $warehouses = $this->tenant->warehouses()->orderBy('name')->get();

        return view('livewire.dashboard.products.edit', [
            'warehouses' => $warehouses,
        ])->extends('layouts.dashboard');
    }
}
