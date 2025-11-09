<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings\Deposits;

use App\Models\Company;
use App\Models\Deposit;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Company $tenant;

    public Deposit $deposit;

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

    #[On('open-edit-deposit-modal')]
    public function loadCurrentDeposit(int $depositId)
    {
        $this->deposit = Deposit::findOrFail($depositId);

        $this->fill([
            'reference' => $this->deposit->reference,
            'label' => $this->deposit->label,
            'amount' => $this->deposit->amount,
            'bank' => $this->deposit->bank,
            'depositedAt' => $this->deposit->deposited_at?->format('Y-m-d'),
        ]);

        $this->dispatch('open-modal', id: 'edit-deposit');
    }

    public function update()
    {
        // $this->authorize('create', Deposit::class);
        $validated = $this->validate();
        $this->deposit->update($validated);

        $this->reset();

        $this->dispatch('deposit-updated');
        $this->dispatch('notify', 'Versement mis à jour avec succès !');
        $this->dispatch('close-modal', id: 'edit-deposit');
    }

    public function render()
    {
        return view('livewire.dashboard.settings.deposits.edit');
    }
}
