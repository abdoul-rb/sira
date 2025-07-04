<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request, Company $tenant)
    {
        $orders = Order::where('company_id', $tenant->id)->orderBy('created_at', 'desc')->take(5)->get();
        // Log::info("DashboardController::index", ['tenant' => $tenant->slug]);

        // Maintenant $tenant est un objet Company complet
        // dd($tenant);
        return view('dashboard.index', compact('orders', 'tenant'));
    }
}
