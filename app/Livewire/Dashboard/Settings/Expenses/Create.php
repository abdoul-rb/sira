<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Expenses;

use App\Models\Company;
use App\Models\Expense;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Enums\ExpenseCategory;

class Create extends Component
{
    public Company $tenant;

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

    public function resetForm()
    {
        $this->name = '';
        $this->amount = 0;
        $this->category = '';
        $this->spentAt = '';

        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        Expense::create([
            'company_id' => $this->tenant->id,
            'name' => $this->name,
            'amount' => $this->amount,
            'category' => $this->category,
            'spent_at' => $this->spentAt,
        ]);

        $this->dispatch('close-modal', id: 'create-expense');
        $this->dispatch('expense-created');
    }

    public function render()
    {
        $categories = ExpenseCategory::cases();

        return view('livewire.dashboard.settings.expenses.create', [
            'categories' => $categories,
        ]);
    }
}
