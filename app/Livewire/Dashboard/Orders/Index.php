<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Orders;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Company;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithPagination;

    public Company $tenant;

    #[Url]
    public string $search = '';

    #[Url(as: 'field', history: true)]
    #[Locked]
    #[Validate('in:created_at,order_number,status,total_amount')]
    public string $sortField = 'created_at';

    #[Url(as: 'direction', history: true)]
    #[Locked]
    #[Validate('in:asc,desc')]
    public string $sortDirection = 'desc';

    public ?string $status = null;

    public $confirmingDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'status' => ['except' => null],
        'page' => ['except' => 1],
    ];

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function sortBy(string $field, string $direction = 'desc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
        $this->dispatch('sort-updated', field: $field, direction: $direction);
    }

    public function confirmDelete($orderId)
    {
        $this->confirmingDelete = $orderId;
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Commande supprimée avec succès.');
    }

    public function render()
    {
        $query = Order::where('company_id', $this->tenant->id)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('order_number', 'like', "%{$this->search}%")
                        ->orWhere('total_amount', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderBy($this->sortField, $this->sortDirection);

        $orders = $query->paginate(10);

        $creditsOrdersCount = DB::table('orders')->where('company_id', $this->tenant->id)->where('payment_status', PaymentStatus::CREDIT)->count();
        $totalSales = DB::table('orders')->where('company_id', $this->tenant->id)->sum('total_amount');

        return view('livewire.dashboard.orders.index', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
            'creditsOrdersCount' => $creditsOrdersCount,
            'totalSales' => $totalSales
        ]);
    }
}
