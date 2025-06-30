<?php

namespace App\Livewire\Dashboard\Order;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Company;
use App\Models\Order;
use Livewire\Component;

class Edit extends Component
{
    public Company $tenant;

    public Order $order;

    public array $data = [];

    public function mount(Company $tenant, Order $order)
    {
        $this->tenant = $tenant;
        $this->order = $order;
        $this->data = $order->toArray();
    }

    public function update()
    {
        $validated = app(UpdateOrderRequest::class)->validated();
        $this->order->update($validated);
        session()->flash('success', 'Commande modifiée avec succès.');

        return redirect()->route('dashboard.orders.edit', [$this->tenant, $this->order]);
    }

    public function render()
    {
        return view('livewire.dashboard.order.edit', [
            'statuses' => OrderStatus::cases(),
        ])->extends('layouts.dashboard');
    }
}
