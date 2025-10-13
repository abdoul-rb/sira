<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Suppliers;

use App\Models\Company;
use App\Models\Supplier;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public Company $tenant;

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

    public function resetForm()
    {
        $this->name = '';
        $this->main = false;
        $this->email = '';
        $this->phoneNumber = '';
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        // Si c'est le premier entrepôt de l'entreprise, le marquer comme par défaut
        if ($this->tenant->suppliers()->count() === 0) {
            $this->main = true;
        }

        $supplier = Supplier::create([
            'company_id' => $this->tenant->id,
            'name' => $this->name,
            'email' => $this->email ?: null,
            'phone_number' => $this->phoneNumber ?: null,
        ]);

        if ($this->main) {
            $supplier->markAsMain();
        }

        $this->dispatch('close-modal', id: 'create-supplier');
        $this->dispatch('supplier-created');
    }

    public function render()
    {
        return view('livewire.dashboard.settings.suppliers.create');
    }
}
