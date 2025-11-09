<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Expenses;

use App\Enums\ExpenseCategory;
use App\Models\Company;
use App\Models\Expense;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Company $tenant;

    public Expense $expense;

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|numeric|min:0')]
    public float $amount = 0;

    #[Rule('required|string|max:255')]
    public string $category = '';

    #[Rule('required|date')]
    public string $spentAt = '';

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    #[On('open-edit-expense-modal')]
    public function loadCurrentExpense(int $expenseId)
    {
        $this->expense = Expense::findOrFail($expenseId);

        $this->fill([
            'name' => $this->expense->name,
            'amount' => $this->expense->amount,
            'category' => $this->expense->category,
            'spentAt' => $this->expense->spent_at?->format('Y-m-d'),
        ]);

        $this->dispatch('open-modal', id: 'edit-expense');
    }

    public function update()
    {
        // $this->authorize('create', Expense::class);
        $validated = $this->validate();
        $this->expense->update($validated);

        $this->reset();

        $this->dispatch('expense-updated');
        $this->dispatch('notify', 'Dépense mis à jour avec succès !');
        $this->dispatch('close-modal', id: 'edit-expense');
    }

    public function render()
    {
        $categories = ExpenseCategory::cases();

        return view('livewire.dashboard.settings.expenses.edit', [
            'categories' => $categories,
        ]);
    }
}
