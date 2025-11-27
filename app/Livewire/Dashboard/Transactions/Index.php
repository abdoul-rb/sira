<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Transactions;

use App\Models\Company;
use App\Models\Deposit;
use App\Models\Expense;
use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public Company $tenant;

    #[Url]
    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    public function render()
    {
        $totalCashIn = Order::where('company_id', $this->tenant->id)
            ->notCredit()
            ->sum('total_amount');

        $totalCashOut = Expense::where('company_id', $this->tenant->id)->sum('amount');

        // Entrées
        $deposits = Deposit::where('company_id', $this->tenant->id)
            ->whereBetween('deposited_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->get()
            ->map(function ($deposit) {
                return [
                    'date' => $deposit->deposited_at,
                    'type' => 'in', // Entrée
                    'label' => $deposit->label,
                    'amount' => $deposit->amount,
                    'category' => $deposit->bank,
                ];
            });

        // Sorties
        $expenses = Expense::where('company_id', $this->tenant->id)
            // ->whereBetween('spent_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->get()
            ->map(function ($expense) {
                return [
                    'date' => $expense->spent_at,
                    'type' => 'out', // Sortie
                    'label' => $expense->name,
                    'amount' => $expense->amount * -1, // On met en négatif pour le calcul
                    'category' => $expense->category,
                ];
            });

        // dd($expenses);

        $cashBalance = $totalCashIn - $totalCashOut;

        // $mouvements = $deposits->merge($expenses)->sortByDesc('date');

        return view('livewire.dashboard.transactions.index', [
            'totalCashIn' => $totalCashIn,
            'totalCashOut' => $totalCashOut,
            'cashBalance' => $cashBalance,
            'expenses' => $expenses,
        ]);
    }
}
