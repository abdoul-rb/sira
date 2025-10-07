<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Deposits;

use App\Models\Company;
use App\Models\Deposit;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public Company $tenant;

    #[Rule('required|string|max:255')]
    public string $reference = '';

    #[Rule('required|string|max:255')]
    public string $label = '';

    #[Rule('required|numeric|min:0')]
    public float $amount = 0;

    #[Rule('required|string|max:255')]
    public string $bank = '';

    #[Rule('required|date')]
    public string $depositedAt = '';

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function resetForm()
    {
        $this->reference = '';
        $this->label = '';
        $this->amount = 0;
        $this->bank = '';
        $this->depositedAt = '';

        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        Deposit::create([
            'company_id' => $this->tenant->id,
            'reference' => $this->reference,
            'label' => $this->label,
            'amount' => $this->amount,
            'deposited_at' => $this->depositedAt,
            'bank' => $this->bank,
        ]);

        $this->dispatch('close-modal', id: 'create-deposit');
        $this->dispatch('deposit-created');
    }

    public function render()
    {
        return view('livewire.dashboard.settings.deposits.create');
    }
}
