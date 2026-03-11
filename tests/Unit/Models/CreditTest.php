<?php

declare(strict_types=1);

use App\Enums\CreditStatus;
use App\Enums\PaymentStatus;
use App\Models\Company;
use App\Models\Credit;
use App\Models\CreditPayment;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;

beforeEach(function () {
    $this->company  = Company::factory()->create();
    $this->customer = Customer::factory()->create([
        'company_id' => $this->company->id,
    ]);
    $this->user = User::factory()->create();

    // Commande à crédit de base : total 10 000, avance 5 000
    $this->order = Order::factory()->create([
        'company_id'     => $this->company->id,
        'customer_id'    => $this->customer->id,
        'total_amount'   => 10000,
        'advance'        => 5000,
        'payment_status' => PaymentStatus::CREDIT,
    ]);
});

// Raccourci pour créer un crédit dans les tests
function makeCredit(array $attributes = []): Credit
{
    return Credit::create(array_merge([
        'company_id' => test()->company->id,
        'order_id'   => test()->order->id,
        'status'     => CreditStatus::PENDING,
    ], $attributes));
}

describe('Credit Model', function () {
    test('peut créer un crédit lié à une commande', function () {
        $credit = makeCredit();

        expect($credit)->toBeInstanceOf(Credit::class)
            ->and($credit->order_id)->toBe($this->order->id)
            ->and($credit->company_id)->toBe($this->company->id)
            ->and($credit->status)->toBe(CreditStatus::PENDING);
    });

    test('appartient à une commande', function () {
        $credit = makeCredit();

        expect($credit->order)->toBeInstanceOf(Order::class)
            ->and($credit->order->id)->toBe($this->order->id);
    });

    describe('Calcul du montant restant', function () {
        test('remaining_amount = total - advance quand aucun versement', function () {
            $credit = makeCredit();
            $credit->load('payments', 'order');

            // 10000 - 5000 = 5000
            expect($credit->remaining_amount)->toBe(5000.0);
        });

        test('remaining_amount diminue avec les versements partiels', function () {
            $credit = makeCredit();

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 2000,
                'payment_method' => 'cash',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            $credit->load('payments', 'order');

            // 10000 - 5000 - 2000 = 3000
            expect($credit->remaining_amount)->toBe(3000.0);
        });

        test('remaining_amount est 0 quand entièrement soldé', function () {
            $credit = makeCredit();

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 5000,
                'payment_method' => 'cash',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            $credit->load('payments', 'order');

            expect($credit->remaining_amount)->toBe(0.0);
        });

        test('remaining_amount ne peut pas être négatif', function () {
            $credit = makeCredit();

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 9999, // Bien au delà du reste dû (5000)
                'payment_method' => 'cash',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            $credit->load('payments', 'order');

            expect($credit->remaining_amount)->toBe(0.0);
        });
    });

    describe('Calcul dynamique du statut', function () {
        test('statut computed est pending par défaut', function () {
            $credit = makeCredit();
            $credit->load('payments', 'order');

            expect($credit->computed_status)->toBe(CreditStatus::PENDING);
        });

        test('statut computed est paid quand remaining_amount <= 0', function () {
            $credit = makeCredit();

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 5000,
                'payment_method' => 'cash',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            $credit->load('payments', 'order');

            expect($credit->computed_status)->toBe(CreditStatus::PAID);
        });

        test('statut computed est overdue quand due_date est dépassée et reste > 0', function () {
            $credit = makeCredit(['due_date' => now()->subDays(5)]);
            $credit->load('payments', 'order');

            expect($credit->computed_status)->toBe(CreditStatus::OVERDUE);
        });

        test('statut computed est paid même avec due_date dépassée si soldé', function () {
            $credit = makeCredit(['due_date' => now()->subDays(5)]);

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 5000,
                'payment_method' => 'cash',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            $credit->load('payments', 'order');

            expect($credit->computed_status)->toBe(CreditStatus::PAID);
        });

        test('statut computed est pending quand due_date est future', function () {
            $credit = makeCredit(['due_date' => now()->addDays(10)]);
            $credit->load('payments', 'order');

            expect($credit->computed_status)->toBe(CreditStatus::PENDING);
        });
    });

    describe('isFullyPaid', function () {
        test('isFullyPaid retourne false quand reste > 0', function () {
            $credit = makeCredit();
            $credit->load('payments', 'order');

            expect($credit->isFullyPaid())->toBeFalse();
        });

        test('isFullyPaid retourne true quand remaining_amount = 0', function () {
            $credit = makeCredit();

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 5000,
                'payment_method' => 'cash',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            $credit->load('payments', 'order');

            expect($credit->isFullyPaid())->toBeTrue();
        });
    });

    describe('markAsPaid', function () {
        test('marque le crédit comme paid en base de données', function () {
            $credit = makeCredit();

            $credit->markAsPaid();

            expect($credit->fresh()->status)->toBe(CreditStatus::PAID);
        });
    });

    describe('Versements multiples', function () {
        test('peut enregistrer plusieurs versements partiels', function () {
            $credit = makeCredit();

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 2000,
                'payment_method' => 'cash',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 3000,
                'payment_method' => 'mobile-money',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            $credit->load('payments', 'order');

            expect($credit->payments)->toHaveCount(2)
                ->and($credit->remaining_amount)->toBe(0.0)
                ->and($credit->isFullyPaid())->toBeTrue();
        });

        test("total_paid inclut l'avance et les versements", function () {
            $credit = makeCredit(); // advance: 5000

            CreditPayment::create([
                'credit_id'      => $credit->id,
                'amount'         => 2000,
                'payment_method' => 'cash',
                'paid_at'        => now(),
                'created_by'     => $this->user->id,
            ]);

            $credit->load('payments', 'order');

            // 5000 (advance) + 2000 (versement) = 7000
            expect($credit->total_paid)->toBe(7000.0);
        });
    });
});
