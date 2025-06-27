<?php

declare(strict_types=1);

use App\Enums\OrderStatus;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quotation;

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->customer = Customer::factory()->create([
        'company_id' => $this->company->id,
    ]);
});

test('Order: array expected columns', function () {
    $order = Order::factory()->create()->fresh();

    expect(array_keys($order->toArray()))->toBe([
        'id',
        'company_id',
        'customer_id',
        'quotation_id',
        'order_number',
        'status',
        'subtotal',
        'tax_amount',
        'shipping_cost',
        'total_amount',
        'shipping_address',
        'billing_address',
        'notes',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

describe('Order Model', function () {
    test('peut créer une commande avec les données de base', function () {
        $order = Order::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order)
            ->toBeInstanceOf(Order::class)
            ->and($order->company_id)->toBe($this->company->id)
            ->and($order->customer_id)->toBe($this->customer->id)
            ->and($order->order_number)->toBeString()
            ->and($order->subtotal)->toBeGreaterThan(0)
            ->and($order->total_amount)->toBeGreaterThan($order->subtotal);
    });

    test('peut créer une commande en attente', function () {
        $order = Order::factory()->pending()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->status)->toBe(OrderStatus::PENDING)
            ->and($order->confirmed_at)->toBeNull()
            ->and($order->shipped_at)->toBeNull()
            ->and($order->delivered_at)->toBeNull()
            ->and($order->cancelled_at)->toBeNull();
    });

    test('peut créer une commande confirmée', function () {
        $order = Order::factory()->confirmed()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->status)->toBe(OrderStatus::CONFIRMED)
            ->and($order->confirmed_at)->not->toBeNull()
            ->and($order->shipped_at)->toBeNull()
            ->and($order->delivered_at)->toBeNull()
            ->and($order->cancelled_at)->toBeNull();
    });

    test('peut créer une commande en préparation', function () {
        $order = Order::factory()->inPreparation()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->status)->toBe(OrderStatus::IN_PREPARATION)
            ->and($order->confirmed_at)->not->toBeNull()
            ->and($order->shipped_at)->toBeNull()
            ->and($order->delivered_at)->toBeNull()
            ->and($order->cancelled_at)->toBeNull();
    });

    test('peut créer une commande expédiée', function () {
        $order = Order::factory()->shipped()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->status)->toBe(OrderStatus::SHIPPED)
            ->and($order->confirmed_at)->not->toBeNull()
            ->and($order->shipped_at)->not->toBeNull()
            ->and($order->delivered_at)->toBeNull()
            ->and($order->cancelled_at)->toBeNull();
    });

    test('peut créer une commande livrée', function () {
        $order = Order::factory()->delivered()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->status)->toBe(OrderStatus::DELIVERED)
            ->and($order->confirmed_at)->not->toBeNull()
            ->and($order->shipped_at)->not->toBeNull()
            ->and($order->delivered_at)->not->toBeNull()
            ->and($order->cancelled_at)->toBeNull();
    });

    test('peut créer une commande annulée', function () {
        $order = Order::factory()->cancelled()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->status)->toBe(OrderStatus::CANCELLED)
            ->and($order->confirmed_at)->toBeNull()
            ->and($order->shipped_at)->toBeNull()
            ->and($order->delivered_at)->toBeNull()
            ->and($order->cancelled_at)->not->toBeNull();
    });

    test('peut marquer une commande comme confirmée', function () {
        $order = Order::factory()->pending()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $order->markAsConfirmed();

        expect($order->fresh()->status)->toBe(OrderStatus::CONFIRMED)
            ->and($order->fresh()->confirmed_at)->not->toBeNull();
    });

    test('peut marquer une commande comme en préparation', function () {
        $order = Order::factory()->confirmed()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $order->markAsInPreparation();

        expect($order->fresh()->status)->toBe(OrderStatus::IN_PREPARATION);
    });

    test('peut marquer une commande comme expédiée', function () {
        $order = Order::factory()->inPreparation()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $order->markAsShipped();

        expect($order->fresh()->status)->toBe(OrderStatus::SHIPPED)
            ->and($order->fresh()->shipped_at)->not->toBeNull();
    });

    test('peut marquer une commande comme livrée', function () {
        $order = Order::factory()->shipped()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $order->markAsDelivered();

        expect($order->fresh()->status)->toBe(OrderStatus::DELIVERED)
            ->and($order->fresh()->delivered_at)->not->toBeNull();
    });

    test('peut marquer une commande comme annulée', function () {
        $order = Order::factory()->pending()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $order->markAsCancelled();

        expect($order->fresh()->status)->toBe(OrderStatus::CANCELLED)
            ->and($order->fresh()->cancelled_at)->not->toBeNull();
    });

    test('vérifie si une commande peut être expédiée', function () {
        $orderConfirmed = Order::factory()->confirmed()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $orderPending = Order::factory()->pending()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($orderConfirmed->canBeShipped())->toBeTrue()
            ->and($orderPending->canBeShipped())->toBeFalse();
    });

    test('vérifie si une commande peut être livrée', function () {
        $orderShipped = Order::factory()->shipped()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $orderConfirmed = Order::factory()->confirmed()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($orderShipped->canBeDelivered())->toBeTrue()
            ->and($orderConfirmed->canBeDelivered())->toBeFalse();
    });

    test('vérifie si une commande peut être annulée', function () {
        $orderPending = Order::factory()->pending()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $orderShipped = Order::factory()->shipped()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($orderPending->canBeCancelled())->toBeTrue()
            ->and($orderShipped->canBeCancelled())->toBeFalse();
    });

    test('appartient à une entreprise', function () {
        $order = Order::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->company)->toBeInstanceOf(Company::class)
            ->and($order->company->id)->toBe($this->company->id);
    });

    test('appartient à un client', function () {
        $order = Order::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->customer)->toBeInstanceOf(Customer::class)
            ->and($order->customer->id)->toBe($this->customer->id);
    });

    test('peut être liée à un devis', function () {
        $quotation = Quotation::factory()->accepted()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $order = Order::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'quotation_id' => $quotation->id,
        ]);

        expect($order->quotation)->toBeInstanceOf(Quotation::class)
            ->and($order->quotation->id)->toBe($quotation->id);
    });

    test('peut avoir des produtests associés', function () {
        $order = Order::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $product = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $order->products()->attach($product->id, [
            'quantity' => 2,
            'unit_price' => 50.00,
            'total_price' => 100.00,
        ]);

        expect($order->products)->toHaveCount(1)
            ->and($order->products->first())->toBeInstanceOf(Product::class)
            ->and($order->products->first()->pivot->quantity)->toBe(2);
    });

    test('calcule correctement les totaux', function () {
        $order = Order::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'subtotal' => 0,
            'tax_amount' => 0,
            'shipping_cost' => 10.00,
            'total_amount' => 0,
        ]);

        $product1 = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $product2 = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $order->products()->attach($product1->id, [
            'quantity' => 2,
            'unit_price' => 50.00,
            'total_price' => 100.00,
        ]);

        $order->products()->attach($product2->id, [
            'quantity' => 1,
            'unit_price' => 75.00,
            'total_price' => 75.00,
        ]);

        $order->calculateTotals();

        expect($order->fresh()->subtotal)->toBe('175.00', 2)
            ->and($order->fresh()->total_amount)->toBe('185.00', 2); // 175 + 10 de frais de port
    });

    test("peut être créée à partir d'un devis", function () {
        $order = Order::factory()->fromQuotation()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->quotation_id)->not->toBeNull()
            ->and($order->quotation)->toBeInstanceOf(Quotation::class);
    });

    describe('Scopes', function () {
        test('peut filtrer les commandes en attente', function () {
            Order::factory()->pending()->count(3)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);
            Order::factory()->confirmed()->count(2)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);

            $pending = Order::pending()->get();

            expect($pending)->toHaveCount(3)
                ->and($pending->every(fn ($order) => $order->status === OrderStatus::PENDING))->toBeTrue();
        });

        test('peut filtrer les commandes confirmées', function () {
            Order::factory()->confirmed()->count(4)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);
            Order::factory()->shipped()->count(1)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);

            $confirmed = Order::confirmed()->get();

            expect($confirmed)->toHaveCount(4)
                ->and($confirmed->every(fn ($order) => $order->status === OrderStatus::CONFIRMED))->toBeTrue();
        });

        test('peut filtrer les commandes livrées', function () {
            Order::factory()->delivered()->count(2)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);
            Order::factory()->cancelled()->count(3)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);

            $delivered = Order::delivered()->get();

            expect($delivered)->toHaveCount(2)
                ->and($delivered->every(fn ($order) => $order->status === OrderStatus::DELIVERED))->toBeTrue();
        });
    });
});
