<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Product;

use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Company;
use App\Models\Product;
use Livewire\Component;

class Create extends Component
{
    public Company $tenant;

    public $name = '';

    public $description = '';

    public $sku = '';

    public $price = '';

    public $stock_quantity = '';

    protected function rules()
    {
        return (new StoreProductRequest)->rules();
    }

    protected function messages()
    {
        return (new StoreProductRequest)->messages();
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['company_id'] = $this->tenant->id;

        Product::create($validated);

        session()->flash('success', 'Produit créé avec succès.');

        return redirect()->route('dashboard.products.index', ['tenant' => $this->tenant]);
    }

    public function render()
    {
        return view('livewire.dashboard.product.create', [
            'tenant' => $this->tenant,
        ])->extends('layouts.dashboard');
    }
}
