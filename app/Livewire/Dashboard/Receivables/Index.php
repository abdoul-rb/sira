<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Receivables;

use App\Enums\PaymentStatus;
use App\Models\Company;
use App\Models\Order;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public Company $tenant;

    #[Url]
    public string $search = '';

    // TODO: Voir avec Oumou, comment gérer le paiement des créances
    public function markAsPaid(int $orderId)
    {
        $order = Order::findOrFail($orderId);

        $order->update([
            'payment_status' => PaymentStatus::CASH,
        ]);

        $this->dispatch('order-updated');
        $this->dispatch('notify', 'Créance marquée comme payée !');
    }

    public function render()
    {
        $query = Order::query()
            ->credit()
            ->when($this->search, function (Builder $q) {
                $q->where(function (Builder $q) {
                    $q->where('order_number', 'like', "%{$this->search}%")
                        ->orWhere('total_amount', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('created_at', 'desc');

        $orders = $query->paginate(10);

        $creditsOrdersCount = $orders->count();
        $totalCredits = $orders->sum('total_amount');

        return view('livewire.dashboard.receivables.index', [
            'orders' => $orders,
            'creditsOrdersCount' => $creditsOrdersCount,
            'totalCredits' => $totalCredits,
        ]);
    }
}
