<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Company $company)
    {
        $seatCount = $company->getBillableSeatCount();

        // 2. Création de la session Checkout
        return $company->newSubscription('default', config('cashier.price_id'))
            ->quantity($seatCount) // Tarification par utilisateur
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('dashboard.products.index', ['tenant' => $company->slug]) . '?checkout=success',
                'cancel_url' => url()->previous(),
                'metadata' => ['tenant_id' => $company->id],
                'locale' => 'fr',
            ]);
    }
}
