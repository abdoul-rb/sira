<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Shop;

use App\Models\Company;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Requests\Shop\UpdateShopRequest;

class Edit extends Component
{
    use WithFileUploads;

    public Company $tenant;
    public Shop $shop;

    // Propriétés du formulaire
    public $name = '';
    public $description = '';
    public $facebook_url = '';
    public $instagram_url = '';
    public $logo_path;
    public $active = true;

    // Pour l'upload temporaire
    public $new_logo;

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
        $this->shop = $tenant->shop ?? new Shop();
        
        // Remplir le formulaire avec les données existantes
        $this->name = $this->shop->name ?? '';
        $this->description = $this->shop->description ?? '';
        $this->facebook_url = $this->shop->facebook_url ?? '';
        $this->instagram_url = $this->shop->instagram_url ?? '';
        $this->logo_path = $this->shop->logo_path;
        $this->active = $this->shop->active ?? true;
    }

    public function save()
    {
        $validated = $this->validate();
        
        // Gérer l'upload du logo si un nouveau est fourni
        if ($this->new_logo) {
            $filename = $this->new_logo->getClientOriginalName();
            $path = "{$this->tenant->id}/shop/";
            $validated['logo_path'] = "{$path}{$filename}";
            
            // Supprimer l'ancien logo s'il existe
            if ($this->shop->logo_path) {
                Storage::disk('public')->delete($this->shop->logo_path);
            }
            
            // Stocker le nouveau logo
            $this->new_logo->storeAs($path, $filename, 'public');
        }

        // Mettre à jour ou créer la boutique
        if ($this->shop->exists) {
            $this->shop->update($validated);
            session()->flash('success', 'Boutique mise à jour avec succès.');
        } else {
            $validated['company_id'] = $this->tenant->id;
            $this->shop = Shop::create($validated);
            session()->flash('success', 'Boutique créée avec succès.');
        }

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
