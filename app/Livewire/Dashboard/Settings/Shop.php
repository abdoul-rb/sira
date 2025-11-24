<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings;

use App\Models\Company;
use Livewire\Attributes\On;
use Livewire\Component;

class Shop extends Component
{
    public Company $tenant;

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

    public function getPublicShopUrl(): ?string
    {
        if (! $this->tenant->shop || ! $this->tenant->shop->active) {
            return null;
        }

        return route('shop.public', [$this->tenant->slug, $this->tenant->shop->slug]);
    }

    public function render()
    {
        return view('livewire.dashboard.settings.shop')->extends('layouts.dashboard');
    }
}
