<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Receivables;

use App\Actions\Credit\RecordPayment as RecordPaymentAction;
use App\Enums\PaymentMethod;
use App\Models\Company;
use App\Models\Credit;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class RecordPayment extends Component
{
    public Company $tenant;

    public ?int $selectedCreditId = null;

    public string $paymentAmount = '';

    public string $paymentMethod = '';

    public string $paymentNote = '';

    public function mount(Company $tenant): void
    {
        $this->tenant = $tenant;
        $this->paymentMethod = PaymentMethod::CASH->value;
    }

    #[On('open-record-payment-modal')]
    public function loadCredit(int $creditId): void
    {
        $this->resetErrorBag();
        $this->selectedCreditId = $creditId;
        $this->paymentAmount = '';
        $this->paymentMethod = PaymentMethod::CASH->value;
        $this->paymentNote = '';

        $this->dispatch('open-modal', id: 'record-payment-modal');
    }

    #[Computed]
    public function selectedCredit(): ?Credit
    {
        if (! $this->selectedCreditId) {
            return null;
        }

        return Credit::with(['order.customer', 'payments'])->find($this->selectedCreditId);
    }

    public function save(RecordPaymentAction $action): void
    {
        $credit = $this->selectedCredit;

        if (! $credit) {
            return;
        }

        $this->validate([
            'paymentAmount' => ['required', 'numeric', 'min:1'],
            'paymentMethod' => ['required', 'string', 'in:' . implode(',', PaymentMethod::values())],
            'paymentNote' => ['nullable', 'string', 'max:500'],
        ]);

        // Vérifier que le montant ne dépasse pas le reste dû
        $remaining = $credit->remaining_amount;
        if ((float) $this->paymentAmount > $remaining) {
            $this->addError(
                'paymentAmount',
                "Le montant saisi ({$this->paymentAmount} FCFA) dépasse le reste dû ({$remaining} FCFA)."
            );

            return;
        }

        $action->handle($credit, [
            'amount' => (float) $this->paymentAmount,
            'payment_method' => $this->paymentMethod,
            'note' => $this->paymentNote ?: null,
            'created_by' => Auth::id(),
        ]);

        $this->dispatch('close-modal', id: 'record-payment-modal');
        $this->dispatch('credit-updated');
        $this->dispatch('notify', 'Versement enregistré avec succès !');

        $this->reset(['selectedCreditId', 'paymentAmount', 'paymentNote']);
    }

    public function render()
    {
        return view('livewire.dashboard.receivables.record-payment', [
            'selectedCredit' => $this->selectedCredit,
        ]);
    }
}
