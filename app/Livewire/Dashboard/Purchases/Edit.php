<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Purchases;

use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public Company $tenant;

    public Purchase $purchase;

    public string $supplierId = '';

    public string $amount = '';

    public string $details = '';

    public string $purchasedAt = '';

    protected function rules(): array
    {
        return (new UpdatePurchaseRequest)->rules();
    }

    protected function messages(): array
    {
        return (new UpdatePurchaseRequest)->messages();
    }

    public function mount()
    {
        $this->tenant = Auth::user()->member->company;
    }

    #[On('open-edit-purchase-modal')]
    public function loadCurrentPurchase(int $purchaseId)
    {
        $this->purchase = Purchase::findOrFail($purchaseId);

        $this->fill([
            'supplierId' => $this->purchase->supplier_id,
            'amount' => $this->purchase->amount,
            'details' => $this->purchase->details,
            'purchasedAt' => $this->purchase->purchased_at->format('Y-m-d'),
        ]);

        $this->dispatch('open-modal', id: 'edit-purchase');
    }

    public function update()
    {
        // $this->authorize('create', Purchase::class);
        $validated = $this->validate();
        $this->purchase->update($validated);

        $this->reset(['supplierId', 'amount', 'details','purchasedAt']);

        $this->dispatch('purchase-updated');
        $this->dispatch('notify', 'Achat mis à jour avec succès !');
        $this->dispatch('close-modal', id: 'edit-purchase');
    }

    public function render()
    {
        $suppliers = Supplier::where('company_id', $this->tenant->id)->get();

        return view('livewire.dashboard.purchases.edit', [
            'suppliers' => $suppliers
        ]);
    }
}
