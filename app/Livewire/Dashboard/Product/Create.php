<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Product;

use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Company;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public Company $tenant;

    public $name = '';

    public $description = '';

    public $featured_image;

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

        // Fermer la modal et rafraîchir la liste
        $this->dispatch('close-modal');
        $this->dispatch('product-created');
        
        // Réinitialiser le formulaire
        $this->reset(['name', 'description', 'featured_image', 'sku', 'price', 'stock_quantity']);
    }

    public function render()
    {
        return view('livewire.dashboard.product.create', [
            'tenant' => $this->tenant,
        ]);
    }
}
