<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Receivables;

use App\Models\Company;
use App\Models\Credit;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public Company $tenant;

    #[Url]
    public string $search = '';

    protected $listeners = ['credit-updated' => '$refresh'];

    public function openPaymentModal(int $creditId): void
    {
        $this->dispatch('open-record-payment-modal', creditId: $creditId)->to(RecordPayment::class);
    }

    public function render()
    {
        $credits = Credit::query()
            ->with(['order.customer', 'order.productLines.product', 'payments'])
            ->when($this->search, function (Builder $q) {
                $q->whereHas('order', function (Builder $q) {
                    $q->where('order_number', 'like', "%{$this->search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(12);

        $totalReceivables = Order::credit()->sum('total_amount');

        return view('livewire.dashboard.receivables.index', [
            'credits' => $credits,
            'totalReceivables' => $totalReceivables,
        ]);
    }
}
