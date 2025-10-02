<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Suppliers;

use App\Models\Company;
use App\Models\Supplier;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public Company $tenant;

    #[Url]
    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function sortBy(string $field, string $direction = 'asc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
    }

    public function toggleMain(Supplier $supplier)
    {
        if (! $supplier->main) {
            $supplier->markAsMain();
            session()->flash('success', 'Fournisseur défini comme principal.');
        }
    }

    /**
     * Écouter l'événement de création de fournisseur
     */
    #[On('supplier-created')]
    public function refreshSuppliers()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Supplier::where('company_id', $this->tenant->id)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $suppliers = $query->paginate(10);

        return view('livewire.dashboard.settings.suppliers.index', [
            'suppliers' => $suppliers,
        ])->extends('layouts.dashboard');
    }
}
