<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Purchases;

use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Models\Company;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{
    public Company $tenant;

    public $supplierId = '';

    public $amount = '';

    public $details = '';

    public $purchasedAt = '';

    protected function rules(): array
    {
        return (new StorePurchaseRequest)->rules();
    }

    protected function messages(): array
    {
        return (new StorePurchaseRequest)->messages();
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function save()
    {
        // $this->authorize('create', Customer::class);

        $this->validate();

        Purchase::create([
            'company_id' => $this->tenant->id,
            'supplier_id' => $this->supplierId,
            'amount' => $this->amount,
            'details' => $this->details,
            'purchased_at' => $this->purchasedAt,
        ]);

        $this->reset(['supplierId', 'amount', 'details', 'purchasedAt']);

        $this->dispatch('close-modal', id: 'add-purchase');
        $this->dispatch('purchase-created');
    }

    #[On('supplier-created')]
    public function refreshSuppliers()
    {
        // Sélectionner le dernier créer
    }

    public function render()
    {
        $suppliers = Supplier::where('company_id', $this->tenant->id)->get();

        return view('livewire.dashboard.purchases.create', [
            'suppliers' => $suppliers,
        ]);
    }
}
