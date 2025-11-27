<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Transactions;

use App\Models\Company;
use App\Models\Expense;
use App\Models\Order;
use Carbon\Carbon;
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

    public $dateStart = null;
    public $dateEnd = null;
    public string $period = 'this_month'; // this_month, this_year, custom
    public string $typeFilter = 'all'; // all, in, out

    public string $sortField = '';

    public string $sortDirection = 'asc';

    public function sortBy(string $field, string $direction = 'asc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
    }

    public function render()
    {
        $totalCashIn = Order::where('company_id', $this->tenant->id)
            ->notCredit()
            ->sum('total_amount');

        $totalCashOut = Expense::where('company_id', $this->tenant->id)->sum('amount');

        // Entrées
        $orders = Order::query()
            ->where('company_id', $this->tenant->id)
            ->notCredit()
            ->selectRaw("
                id,
                company_id,
                (SELECT CONCAT(firstname, ' ', lastname) FROM customers WHERE customers.id = orders.customer_id) as customer,
                order_number as label,
                created_at as date,
                total_amount as amount,
                payment_status as category,
                'in' as type
            ");

        if ($this->search) {
            $orders->where('order_number', 'like', "%{$this->search}%");
        }

        if ($this->dateStart) {
            $orders->whereDate('created_at', '>=', $this->dateStart);
        }

        if ($this->dateEnd) {
            $orders->whereDate('created_at', '<=', $this->dateEnd);
        }

        // Sorties
        $expenses = Expense::query()
            ->where('company_id', $this->tenant->id)
            ->selectRaw("
                id,
                company_id,
                NULL as customer,
                name as label,
                spent_at as date,
                amount,
                category,
                'out' as type
            ");

        if ($this->search) {
            $expenses->where(function(Builder $q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('category', 'like', "%{$this->search}%");
            });
        }

        if ($this->dateStart) {
            $expenses->whereDate('spent_at', '>=', $this->dateStart);
        }

        if ($this->dateEnd) {
            $expenses->whereDate('spent_at', '<=', $this->dateEnd);
        }

        $query = null;

        if ($this->typeFilter === 'in') {
            $query = $orders;
        } elseif ($this->typeFilter === 'out') {
            $query = $expenses;
        } else {
            $query = $orders->toBase()->unionAll($expenses->toBase());
        }

        $transactions = $query
            ->orderBy('date', 'desc')
            ->paginate(10)->getCollection()->transform(function ($transaction) {
                $transaction->date = Carbon::parse($transaction->date);

                return $transaction;
            });

        $cashBalance = $totalCashIn - $totalCashOut;

        return view('livewire.dashboard.transactions.index', [
            'totalCashIn' => $totalCashIn,
            'totalCashOut' => $totalCashOut,
            'cashBalance' => $cashBalance,
            'transactions' => $transactions,
        ]);
    }
}
