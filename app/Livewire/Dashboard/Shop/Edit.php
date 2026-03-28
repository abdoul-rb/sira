<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Shop;

use App\Actions\Profile\UpdateCompanyAction;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Company $tenant;

    // Propriétés du formulaire
    public string $name = '';

    public string $facebookUrl = '';

    public string $instagramUrl = '';

    public string $tiktokUrl = '';

    public bool $active = true;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'facebookUrl' => 'nullable|url|max:255',
            'instagramUrl' => 'nullable|url|max:255',
            'tiktokUrl' => 'nullable|url|max:255',
            'active' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Le nom de la boutique est requis.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'facebookUrl.url' => "L'URL Facebook n'est pas valide.",
            'instagramUrl.url' => "L'URL Instagram n'est pas valide.",
            'tiktokUrl.url' => "L'URL TikTok n'est pas valide.",
        ];
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;

        $this->fill([
            'name' => $this->tenant->name ?? '',
            'facebookUrl' => $this->tenant->facebook_url ?? '',
            'instagramUrl' => $this->tenant->instagram_url ?? '',
            'tiktokUrl' => $this->tenant->tiktok_url ?? '',
            'active' => $this->tenant->active ?? true,
        ]);
    }

    public function save(UpdateCompanyAction $action)
    {
        $validated = $this->validate();

        // Prepare data for UpdateCompanyAction
        $data = [
            'name' => $validated['name'],
            'facebookUrl' => $validated['facebookUrl'] ?? null,
            'instagramUrl' => $validated['instagramUrl'] ?? null,
            'tiktokUrl' => $validated['tiktokUrl'] ?? null,
        ];

        // Déléguer la logique métier à l'Action
        $this->tenant = $action->handle($this->tenant, $data);

        // Rafraîchir
        $this->tenant->refresh();

        session()->flash('success', 'Boutique mise à jour avec succès.');

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
