<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Warehouse;

use App\Models\Company;
use App\Models\Warehouse;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateModal extends Component
{
    public Company $tenant;

    public bool $show = false;

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('nullable|string|max:255')]
    public string $location = '';

    #[Rule('boolean')]
    public bool $default = false;

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function resetForm()
    {
        $this->name = '';
        $this->location = '';
        $this->default = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        // Si c'est le premier entrepôt de l'entreprise, le marquer comme par défaut
        if ($this->tenant->warehouses()->count() === 0) {
            $this->default = true;
        }

        $warehouse = Warehouse::create([
            'company_id' => $this->tenant->id,
            'name' => $this->name,
            'location' => $this->location ?: null,
            'default' => $this->default,
        ]);

        // Si cet entrepôt est marqué comme par défaut, s'assurer qu'il est bien le seul
        if ($this->default) {
            $warehouse->markAsDefault();
        }

        // Émettre l'événement pour rafraîchir la liste
        $this->dispatch('close-modal', id: 'create-warehouse');
        $this->dispatch('warehouse-created');
    }

    public function render()
    {
        return view('livewire.dashboard.warehouse.create-modal');
    }
}
