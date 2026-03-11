<?php

declare(strict_types=1);

namespace App\Actions\Credit;

use App\Models\Credit;
use App\Models\CreditPayment;
use Illuminate\Support\Facades\DB;

final class RecordPayment
{
    /**
     * Enregistre un versement sur un crédit.
     *
     * @param  array{amount: float, payment_method: string, note: ?string, created_by: int}  $data
     */
    public function handle(Credit $credit, array $data): CreditPayment
    {
        return DB::transaction(function () use ($credit, $data) {
            $payment = CreditPayment::create([
                'credit_id' => $credit->id,
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'paid_at' => now(),
                'created_by' => $data['created_by'],
            ]);

            // Recharger les paiements pour recalculer le montant restant
            $credit->load('payments');

            // Si le crédit est entièrement soldé, mettre à jour le statut en base
            if ($credit->isFullyPaid()) {
                $credit->markAsPaid();
            }

            return $payment;
        });
    }
}
