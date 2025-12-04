<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Expenses;

use App\Models\Company;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
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

    /**
     * Écouter l'événement de création de fournisseur
     */
    #[On('expense-created')]
    public function refreshExpenses()
    {
        $this->resetPage();
    }

    /**
     * Ouvre le forumulaire modal d'edition
     *
     * @return void
     */
    public function edit(int $expenseId)
    {
        $this->dispatch('open-edit-expense-modal', expenseId: $expenseId);
    }

    public function render()
    {
        $query = Expense::where('company_id', $this->tenant->id)
            ->when($this->search, function (Builder $q) {
                $q->where(function (Builder $q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $expenses = $query->paginate(10);

        return view('livewire.dashboard.settings.expenses.index', [
            'expenses' => $expenses,
        ]);
    }
}
