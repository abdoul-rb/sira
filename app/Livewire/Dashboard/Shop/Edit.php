<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Shop;

use App\Actions\Shop\UpdateOrCreateShopAction;
use App\Http\Requests\Shop\UpdateShopRequest;
use App\Models\Company;
use App\Models\Shop;
use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Company $tenant;

    public Shop $shop;

    // Propriétés du formulaire
    public string $name = '';

    public string $description = '';

    public string $facebookUrl = '';

    public string $instagramUrl = '';

    public string $logoPath = '';

    public bool $active = true;

    // Pour l'upload temporaire
    public ?UploadedFile $newLogo = null;

    protected function rules(): array
    {
        return (new UpdateShopRequest)->rules();
    }

    protected function messages(): array
    {
        return (new UpdateShopRequest)->messages();
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;

        // Récupérer ou créer la boutique
        $this->shop = $tenant->shop ?? new Shop;

        $this->fill([
            'name' => $this->shop->name ?? '',
            'description' => $this->shop->description ?? '',
            'facebookUrl' => $this->shop->facebook_url ?? '',
            'instagramUrl' => $this->shop->instagram_url ?? '',
            'logoPath' => $this->shop->logo_path ?? '',
            'active' => $this->shop->active ?? true,
        ]);
    }

    public function save(UpdateOrCreateShopAction $action)
    {
        $validated = $this->validate();

        // Ajouter le nouveau logo aux données si présent
        if ($this->newLogo) {
            $validated['newLogo'] = $this->newLogo;
        }

        // Déléguer la logique métier à l'Action
        $isNewShop = ! $this->shop->exists;
        $this->shop = $action->handle($this->tenant, $this->shop, $validated);

        // Message de succès approprié
        $message = $isNewShop
            ? 'Boutique créée avec succès.'
            : 'Boutique mise à jour avec succès.';
        session()->flash('success', $message);

        // Rafraîchir la relation shop de l'entreprise
        $this->tenant->refresh();
        $this->tenant->load('shop');

        // Fermer la modal
        $this->dispatch('close-modal', id: 'edit-shop');

        // Rafraîchir la page pour afficher les nouvelles informations
        $this->dispatch('shop-updated');
    }

    public function render()
    {
        return view('livewire.dashboard.shop.edit');
    }
}
