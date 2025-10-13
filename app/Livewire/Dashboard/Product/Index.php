<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Product;

use App\Models\Company;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public Company $tenant;

    #[Url]
    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    public $confirmingDelete = null;

    /* protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
    ]; */

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Écouter l'événement de mise à jour de la boutique
     */
    #[On('shop-updated')]
    public function refreshShop()
    {
        $this->tenant->refresh();
        $this->tenant->load('shop');
    }

    public function sortBy(string $field, string $direction = 'desc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;

        // Dispatch l'événement avec les valeurs des propriétés
        $this->dispatch('sort-updated', field: $field, direction: $direction);
    }

    public function confirmDelete($productId)
    {
        $this->confirmingDelete = $productId;
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        $this->confirmingDelete = null;

        session()->flash('success', 'Produit supprimé avec succès.');
    }

    /**
     * Génère l'URL publique de la boutique
     */
    public function getPublicShopUrl(): ?string
    {
        if (!$this->tenant->shop || !$this->tenant->shop->active) {
            return null;
        }

        return route('shop.public', [$this->tenant->slug, $this->tenant->shop->slug]);
    }

    public function render()
    {
        $query = Product::where('company_id', $this->tenant->id)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $products = $query->paginate(10);

        return view('livewire.dashboard.product.index', [
            'products' => $products,
        ])->extends('layouts.dashboard');
    }
}
