<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Order;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\Customer;
use Livewire\Component;
use App\Http\Requests\Order\StoreOrderRequest;

class Edit extends Component
{
    public Company $tenant;

    public Order $order;

    public $customer_id = null;

    public $quotation_id = null;

    public $status = null;

    public $notes = null;

    public $shipping_cost = null;

    public $shipping_address = null;

    public $billing_address = null;

    public function mount(Company $tenant, Order $order)
    {
        $this->tenant = $tenant;
        $this->order = $order;

        if ($this->order) {
            $this->fill(
                $this->order->only(['customer_id', 'quotation_id', 'notes', 'shipping_cost', 'shipping_address', 'billing_address'])
            );
            
            $this->status = $this->order->status->value;
        }
    }

    protected function rules(): array
    {
        return (new StoreOrderRequest)->rules();
    }

    public function update()
    {
        $validated = $this->validate();

        $this->order->update($validated);
        session()->flash('success', 'Commande modifiée avec succès.');

        return redirect()->route('dashboard.orders.index', [$this->tenant]);
    }

    public function render()
    {
        $customers = Customer::where('company_id', $this->tenant->id)->get();

        return view('livewire.dashboard.order.edit', [
            'statuses' => OrderStatus::cases(),
            'customers' => $customers,
        ])->extends('layouts.dashboard');
    }
}
