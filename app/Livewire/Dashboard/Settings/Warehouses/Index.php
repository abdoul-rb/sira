<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Warehouses;

use App\Models\Company;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
        if (! $warehouse->default) {
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

    /**
     * Ouvre le forumulaire modal d'edition
     *
     * @return void
     */
    public function edit(int $warehouseId)
    {
        $this->dispatch('open-edit-warehouse-modal', warehouseId: $warehouseId);
    }

    public function render()
    {
        $query = Warehouse::where('company_id', $this->tenant->id)
            ->when($this->search, function (Builder $q) {
                $q->where(function (Builder $q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $warehouses = $query->paginate(10);

        return view('livewire.dashboard.settings.warehouses.index', [
            'warehouses' => $warehouses,
        ])->extends('dashboard.settings.index')
            ->section('viewbody');
    }
}
