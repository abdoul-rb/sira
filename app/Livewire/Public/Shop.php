<?php

declare(strict_types=1);

namespace App\Livewire\Public;

use App\Models\Company;
use App\Models\Product;
use App\Models\Shop as ShopModel;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    use WithPagination;

    public Company $tenant;
    public ShopModel $shop;

    public string $search = '';

    public function mount(Company $tenant, string $shopSlug)
    {
        $this->tenant = $tenant;

        // dd($shopSlug, url()->current(), ShopModel::get());

        // Check si la boutique exist sinon gérer
        
        // Récupérer la boutique par son slug
        $this->shop = ShopModel::where('slug', $shopSlug)
            ->where('company_id', $tenant->id)
            ->where('active', true)
            ->with('company')
            ->firstOrFail();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Récupérer tous les produits de la boutique (entreprise)
        $products = Product::where('company_id', $this->tenant->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%")
                        ->orWhere('sku', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.public.shop', [
            'products' => $products,
        ])->layout('layouts.app');
    }
}
