<?php

declare(strict_types=1);

use App\Actions\Order\CreateAction;
use App\Enums\CreditStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Company;
use App\Models\Credit;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Warehouse;

beforeEach(function () {
    $this->company   = Company::factory()->create();
    $this->customer  = Customer::factory()->create(['company_id' => $this->company->id]);
    $this->warehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $this->action    = app(CreateAction::class);

    $this->baseData = [
        'company_id'   => $this->company->id,
        'customerId'   => $this->customer->id,
        'warehouseId'  => $this->warehouse->id,
        'status'       => OrderStatus::PENDING,
        'subtotal'     => 10000,
        'discount'     => 0,
        'advance'      => 0,
        'total'        => 10000,
    ];
});

describe('CreateAction — Création automatique du crédit', function () {
    test('crée un credit automatiquement quand payment_status = CREDIT', function () {
        $data = array_merge($this->baseData, [
            'paymentStatus' => PaymentStatus::CREDIT,
            'advance'       => 5000,
        ]);

        $order = $this->action->handle($data, []);

        expect(Credit::count())->toBe(1);

        $this->assertDatabaseHas('credits', [
            'order_id'   => $order->id,
            'company_id' => $this->company->id,
            'status'     => CreditStatus::PENDING->value,
            'due_date'   => null,
        ]);
    });

    test('le credit a le statut pending par défaut', function () {
        $data = array_merge($this->baseData, [
            'paymentStatus' => PaymentStatus::CREDIT,
        ]);

        $order = $this->action->handle($data, []);

        $credit = Credit::where('order_id', $order->id)->first();

        expect($credit)->not->toBeNull()
            ->and($credit->status)->toBe(CreditStatus::PENDING)
            ->and($credit->due_date)->toBeNull();
    });

    test('le credit est lié à la bonne commande', function () {
        $data = array_merge($this->baseData, [
            'paymentStatus' => PaymentStatus::CREDIT,
        ]);

        $order  = $this->action->handle($data, []);
        $credit = Credit::where('order_id', $order->id)->first();

        expect($credit->order_id)->toBe($order->id)
            ->and($credit->company_id)->toBe($this->company->id);
    });

    test("ne crée pas de credit pour une commande payée en cash", function () {
        $data = array_merge($this->baseData, [
            'paymentStatus' => PaymentStatus::CASH,
        ]);

        $this->action->handle($data, []);

        expect(Credit::count())->toBe(0);
    });

    test("ne crée pas de credit pour une commande payée en mobile money", function () {
        $data = array_merge($this->baseData, [
            'paymentStatus' => PaymentStatus::MOBILE_MONEY,
        ]);

        $this->action->handle($data, []);

        expect(Credit::count())->toBe(0);
    });

    test('une commande crédit sans avance crée quand même un credit', function () {
        $data = array_merge($this->baseData, [
            'paymentStatus' => PaymentStatus::CREDIT,
            'advance'       => 0,
        ]);

        $order = $this->action->handle($data, []);

        expect(Credit::count())->toBe(1)
            ->and(Credit::where('order_id', $order->id)->exists())->toBeTrue();
    });

    test('la relation creditRecord() sur Order pointe vers le credit créé', function () {
        $data = array_merge($this->baseData, [
            'paymentStatus' => PaymentStatus::CREDIT,
        ]);

        $order  = $this->action->handle($data, []);
        $credit = $order->creditRecord;

        expect($credit)->not->toBeNull()
            ->and($credit)->toBeInstanceOf(Credit::class)
            ->and($credit->order_id)->toBe($order->id);
    });
});
