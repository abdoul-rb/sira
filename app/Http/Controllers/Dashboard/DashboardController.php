<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request, Company $tenant)
    {
        $orders = Cache::remember("dashboard-last-orders-{$tenant->id}", 60 * 60, function () use ($tenant) {
            return Order::where('company_id', $tenant->id)->orderBy('created_at', 'desc')->take(5)->get();
        });

        $customersCount = DB::table('customers')->where('company_id', $tenant->id)->count();

        $productsCount = Product::where('company_id', $tenant->id)->count();
        $productsStock = Product::where('company_id', $tenant->id)->sum('stock_quantity');

        $totalSales = Order::where('company_id', $tenant->id)->sum('total_amount');

        $totalOrders = Order::where('company_id', $tenant->id)->count();

        // 1. ARGENT ENTRÉ (Ventes réellement encaissées)
        $cashIn = Order::where('company_id', $tenant->id)
            ->notCredit()
            ->sum('total_amount');

        // 2. ARGENT SORTI (Dépenses / Charges)
        $totalCashOut = Expense::where('company_id', $tenant->id)->sum('amount');

        // Trésorerie Actuelle: l'argent réel dans la caisse
        $cashBalance = $cashIn - $totalCashOut;

        $monthExpenses = (float) Expense::where('company_id', $tenant->id)
            ->whereMonth('spent_at', now()->month)
            ->whereYear('spent_at', now()->year)
            ->sum('amount');

        $totalCredits = Order::query()
            ->where('company_id', $tenant->id)
            ->credit()
            ->sum('total_amount');

        return view('dashboard.index', [
            'orders' => $orders,
            'tenant' => $tenant,
            'customersCount' => $customersCount,
            'productsCount' => $productsCount,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'cashBalance' => $cashBalance,
            'monthExpenses' => $monthExpenses,
            'totalCredits' => $totalCredits,
        ]);
    }
}
