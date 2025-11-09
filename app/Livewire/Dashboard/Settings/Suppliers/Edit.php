<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Suppliers;

use App\Models\Company;
use App\Models\Supplier;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Company $tenant;

    public Supplier $supplier;

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('nullable|email|max:255')]
    public string $email = '';

    #[Rule('nullable|string|max:255')]
    public string $phoneNumber = '';

    #[Rule('boolean')]
    public bool $main = false;

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    #[On('open-edit-supplier-modal')]
    public function loadCurrentSupplier(int $supplierId)
    {
        $this->supplier = Supplier::findOrFail($supplierId);

        $this->fill([
            'name' => $this->supplier->name,
            'email' => $this->supplier->email,
            'phoneNumber' => $this->supplier->phone_number,
        ]);

        $this->dispatch('open-modal', id: 'edit-supplier');
    }

    public function update()
    {
        // $this->authorize('create', Supplier::class);
        $validated = $this->validate();
        $this->supplier->update($validated);

        $this->reset();

        $this->dispatch('supplier-updated');
        $this->dispatch('notify', 'Fournisseur mis à jour avec succès !');
        $this->dispatch('close-modal', id: 'edit-supplier');
    }

    public function render()
    {
        return view('livewire.dashboard.settings.suppliers.edit');
    }
}
