<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Deposits;

use App\Models\Company;
use App\Models\Deposit;
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

    public string $sortField = 'label';

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

    /**
     * Écouter l'événement de création de fournisseur
     */
    #[On('deposit-created')]
    public function refreshDeposits()
    {
        $this->resetPage();
    }

    /**
     * Ouvre le forumulaire modal d'edition
     *
     * @return void
     */
    public function edit(int $depositId)
    {
        $this->dispatch('open-edit-deposit-modal', depositId: $depositId);
    }

    public function render()
    {
        $query = Deposit::where('company_id', $this->tenant->id)
            ->when($this->search, function (Builder $q) {
                $q->where(function (Builder $q) {
                    $q->where('label', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $deposits = $query->paginate(10);

        return view('livewire.dashboard.settings.deposits.index', [
            'deposits' => $deposits,
        ])->extends('dashboard.settings.index')
            ->section('viewbody');
    }
}
