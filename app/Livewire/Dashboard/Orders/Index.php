<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Orders;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Company;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithPagination;

    public Company $tenant;

    #[Url]
    public string $search = '';

    public string $dateFilter = 'all';

    public string $paymentStatusFilter = 'all';

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
        'dateFilter' => ['except' => 'all'],
        'paymentStatusFilter' => ['except' => 'today'],
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentStatusFilter()
    {
        $this->resetPage();
    }

    private function getDateRange(): ?array
    {
        if ($this->dateFilter === 'all') {
            return null;
        }

        $now = Carbon::now();

        return match ($this->dateFilter) {
            'today' => [
                'start' => $now->copy()->startOfDay(),
                'end' => $now->copy()->endOfDay(),
            ],
            'yesterday' => [
                'start' => $now->copy()->subDay()->startOfDay(),
                'end' => $now->copy()->subDay()->endOfDay(),
            ],
            'last_3_days' => [
                'start' => $now->copy()->subDays(2)->startOfDay(),
                'end' => $now->copy()->endOfDay(),
            ],
            'this_week' => [
                'start' => $now->copy()->startOfWeek(),
                'end' => $now->copy()->endOfWeek(),
            ],
            'last_week' => [
                'start' => $now->copy()->subWeek()->startOfWeek(),
                'end' => $now->copy()->subWeek()->endOfWeek(),
            ],
            'this_month' => [
                'start' => $now->copy()->startOfMonth(),
                'end' => $now->copy()->endOfMonth(),
            ],
            'last_month' => [
                'start' => $now->copy()->subMonth()->startOfMonth(),
                'end' => $now->copy()->subMonth()->endOfMonth(),
            ],
            'last_3_months' => [
                'start' => $now->copy()->subMonths(3)->startOfMonth(),
                'end' => $now->copy()->endOfMonth(),
            ],
            'this_year' => [
                'start' => $now->copy()->startOfYear(),
                'end' => $now->copy()->endOfYear(),
            ],
            'custom' => [
                'start' => $this->customStartDate ? Carbon::parse($this->customStartDate)->startOfDay() : $now->copy()->startOfMonth(),
                'end' => $this->customEndDate ? Carbon::parse($this->customEndDate)->endOfDay() : $now->copy()->endOfDay(),
            ],
            default => null
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function destroy(int $orderId)
    {
        dd($orderId);
        $order = Order::findOrFail($orderId);

        $order->delete();

        $this->dispatch('order-deleted');
        $this->dispatch('notify', 'Vente supprimée !');
    }

    public function render()
    {
        $dateRange = $this->getDateRange();

        $query = Order::where('company_id', $this->tenant->id)
            ->with(['customer', 'products'])
            ->when($dateRange !== null, function (Builder $q) use ($dateRange) {
                $q->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            })
            ->when($this->search, function (Builder $q) {
                $q->where(function (Builder $q) {
                    $q->where('order_number', 'like', "%{$this->search}%")
                        ->orWhere('total_amount', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderBy($this->sortField, $this->sortDirection);

        $orders = $query->paginate(10);

        $creditsOrdersCount = DB::table('orders')->where('company_id', $this->tenant->id)->where('payment_status', PaymentStatus::CREDIT)->count();
        $totalSales = DB::table('orders')->where('company_id', $this->tenant->id)->sum('total_amount');

        $periods = [
            'all' => 'Toutes les périodes',
            'yesterday' => 'Hier',
            'today' => "Aujourd'hui",
            'last_3_days' => '3 derniers jours',
            'this_week' => 'Cette semaine',
            'last_week' => 'Semaine dernière',
            'this_month' => 'Ce mois-ci',
            'last_month' => 'Mois dernier',
            'last_3_months' => '3 derniers mois',
            'this_year' => 'Cette année',
        ];

        return view('livewire.dashboard.orders.index', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
            'creditsOrdersCount' => $creditsOrdersCount,
            'totalSales' => $totalSales,
            'periods' => $periods,
        ]);
    }
}
