<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Products;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithPagination;

    public Company $company;

    #[Url]
    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    /* protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
    ]; */

    public function mount(Company $company)
    {
        $this->company = $company;

        if (request()->get('checkout') === 'success') {
            session()->flash('success', 'Abonnement activé avec succès ! Merci de votre confiance.');

            return redirect()->route('dashboard.products.index', ['company' => $this->company->slug]);
        }
    }

    /**
     * Écouter l'événement de mise à jour de la boutique
     */
    // #[On('product-created')]
    public function refreshProducts() {}

    public function sortBy(string $field, string $direction = 'desc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;

        // Dispatch l'événement avec les valeurs des propriétés
        $this->dispatch('sort-updated', field: $field, direction: $direction);
    }

    /**
     * Génère l'URL publique de la boutique
     */
    public function getPublicShopUrl(): ?string
    {
        if (! $this->company->shop || ! $this->company->shop->active) {
            return null;
        }

        return route('shop.public', [$this->company->slug, $this->company->shop->slug]);
    }

    /**
     * Open the modal to upgrade to Pro
     */
    public function openProModal(): void
    {
        $this->dispatch('open-modal', id: 'upgrade-pro');
    }

    /**
     * Ouvre le forumulaire modal d'edition
     *
     * @return void
     */
    public function edit(int $productId)
    {
        $this->dispatch('open-edit-product-modal', productId: $productId);
    }

    /**
     * Remove the specified resource from storage.
     *
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
        $this->dispatch('notify', 'Produit supprimé avec succès !');
    }

    public function render()
    {
        $query = Product::where('company_id', $this->company->id)
            ->when($this->search, function (Builder $q) {
                $q->where(function (Builder $q) {
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
