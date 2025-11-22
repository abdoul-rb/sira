<?php

declare(strict_types= 1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Company;

class InvoiceController extends Controller
{
    public function show(Request $request, Company $tenant, Order $order)
    {
        // Ensure the order belongs to the current tenant
        if ($order->company_id !== $tenant->id) {
            abort(404);
        }

        $order->load(['customer', 'products', 'company']);

        $pdf = Pdf::loadView('pdf.invoice', [
            'order' => $order,
            'company' => $order->company,
            'customer' => $order->customer,
        ]);

        return $pdf->stream("facture-{$order->order_number}.pdf");
    }
}
