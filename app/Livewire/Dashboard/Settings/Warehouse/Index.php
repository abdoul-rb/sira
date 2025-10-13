<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Warehouse;

use App\Models\Company;
use App\Models\Warehouse;
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

    public function toggleDefault(Warehouse $warehouse)
    {
        if (!$warehouse->default) {
            $warehouse->markAsDefault();
            session()->flash('success', 'Entrepôt défini comme par défaut.');
        }
    }

    /**
     * Écouter l'événement de création d'entrepôt
     */
    #[On('warehouse-created')]
    public function refreshWarehouses()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Warehouse::where('company_id', $this->tenant->id)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $warehouses = $query->paginate(10);

        return view('livewire.dashboard.settings.warehouse.index', [
            'warehouses' => $warehouses,
        ])->extends('layouts.dashboard');
    }
}
