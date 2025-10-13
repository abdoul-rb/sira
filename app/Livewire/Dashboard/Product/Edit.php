<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Product;

use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Company;
use App\Models\Product;
use Livewire\Component;

class Edit extends Component
{
    public Company $tenant;

    public Product $product;

    public $name;

    public $description;

    public $sku;

    public $price;

    public $stock_quantity;

    protected function rules()
    {
        return (new UpdateProductRequest)->rules();
    }

    protected function messages()
    {
        return (new UpdateProductRequest)->messages();
    }

    public function mount(Company $tenant, Product $product)
    {
        $this->tenant = $tenant;

        if ($product) {
            $this->fill([
                'product' => $product,
                'name' => $product->name,
                'description' => $product->description,
                'sku' => $product->sku,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity,
            ]);
        }
    }

    public function save()
    {
        $validated = $this->validate();
        $this->product->update($validated);
        session()->flash('success', 'Produit modifié avec succès.');

        return redirect()->route('dashboard.products.index', ['tenant' => $this->tenant]);
    }

    public function render()
    {
        return view('livewire.dashboard.product.edit', [
            'tenant' => $this->tenant,
        ])->extends('layouts.dashboard');
    }
}
