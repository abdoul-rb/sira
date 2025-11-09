<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Products;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
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
    ##[On('product-created')]
    public function refreshProducts()
    {
        
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

    /**
     * Ouvre le forumulaire modal d'edition
     *
     * @param integer $productId
     * @return void
     */
    public function edit(int $productId)
    {
        $this->dispatch('open-edit-product-modal', productId: $productId);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $productId
     * @return void
     */
    public function destroy(int $productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->featured_image && Storage::disk('public')->exists($product->featured_image)) {
            Storage::disk('public')->delete($product->featured_image);
        }
        
        $product->delete();

        $this->dispatch('product-deleted');
        $this->dispatch('notify', 'Produit supprimé !');
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

        return view('livewire.dashboard.products.index', [
            'products' => $products,
        ]);
    }
}
