<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Order;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Company;
use App\Models\Order;
use Livewire\Component;
use App\Models\Customer;

class Create extends Component
{
    public Company $tenant;

    public $customer_id = null;

    public $quotation_id = null;

    public $status = null;

    public $notes = null;

    public $shipping_cost = null;

    public $shipping_address = null;

    public $billing_address = null;

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
        $this->status = OrderStatus::PENDING->value;
    }

    protected function rules(): array
    {
        return (new StoreOrderRequest)->rules();
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['company_id'] = $this->tenant->id;
        
        $order = Order::create($validated);
        
        session()->flash('success', 'Commande créée avec succès.');
        
        return redirect()->route('dashboard.orders.edit', [$this->tenant, $order]);
    }

    public function render()
    {
        $customers = Customer::where('company_id', $this->tenant->id)->get();

        return view('livewire.dashboard.order.create', [
            'statuses' => OrderStatus::cases(),
            'customers' => $customers,
        ])->extends('layouts.dashboard');
    }
}
