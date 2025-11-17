<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
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

        // dd();

        // dd(resolve('currentTenant'));

        return view('dashboard.index', [
            'orders' => $orders,
            'tenant' => $tenant,
            'customersCount' => $customersCount,
            'productsCount' => $productsCount,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
        ]);
    }
}
