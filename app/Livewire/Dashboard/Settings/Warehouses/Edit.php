<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Warehouses;

use App\Models\Company;
use App\Models\Warehouse;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Company $tenant;

    public Warehouse $warehouse;

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('nullable|string|max:255')]
    public string $location = '';

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    #[On('open-edit-warehouse-modal')]
    public function loadCurrentWarehouse(int $warehouseId)
    {
        $this->warehouse = Warehouse::findOrFail($warehouseId);

        $this->fill([
            'name' => $this->warehouse->name,
            'location' => $this->warehouse->location,
        ]);

        $this->dispatch('open-modal', id: 'edit-warehouse');
    }

    public function update()
    {
        // $this->authorize('create', Warehouse::class);
        $validated = $this->validate();
        $this->warehouse->update($validated);

        $this->reset();

        $this->dispatch('warehouse-updated');
        $this->dispatch('notify', 'Emplacement mis à jour avec succès !');
        $this->dispatch('close-modal', id: 'edit-warehouse');
    }

    public function render()
    {
        return view('livewire.dashboard.settings.warehouses.edit');
    }
}
