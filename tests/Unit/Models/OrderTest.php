<?php

declare(strict_types=1);

use App\Enums\OrderStatus;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Enums\PaymentStatus;

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
        'order_number',
        'status',
        'subtotal',
        'total_amount',
        'paid_at',
        'delivered_at',
        'cancelled_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'warehouse_id',
        'discount',
        'advance',
        'payment_status',
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
            ->and($order->total_amount)->toBeGreaterThan($order->subtotal)
            ->and($order->order_number)->toMatch('/^\d{6}-\d{2}-\d{3}$/')
            ->and($order->order_number)->toHaveLength(13);
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

    test('peut créer une commande livrée', function () {
        $order = Order::factory()->delivered()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($order->status)->toBe(OrderStatus::DELIVERED)
            ->and($order->paid_at)->not->toBeNull()
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

    test('peut marquer une commande comme livrée', function () {
        $order = Order::factory()->delivered()->create([
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

    test('vérifie si une commande peut être annulée', function () {
        $orderPending = Order::factory()->pending()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($orderPending->canBeCancelled())->toBeTrue();
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
            'discount' => 0,
            'advance' => 0,
            'payment_status' => PaymentStatus::CASH,
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
            ->and($order->fresh()->total_amount)->toBe('175.00', 2); // 175 + 0 de frais de port
    });

    describe('Scopes', function () {
        test('peut filtrer les commandes en attente', function () {
            Order::factory()->pending()->count(3)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);

            /* Order::factory()->paid()->count(2)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]); */

            $pending = Order::pending()->get();

            expect($pending)->toHaveCount(3)
                ->and($pending->every(fn ($order) => $order->status === OrderStatus::PENDING))->toBeTrue();
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

    describe('Avec un entrepôt', function () {
        test('créer une commande avec un entrepôt', function () {
            $warehouse = Warehouse::factory()->create([
                'company_id' => $this->company->id,
            ]);

            $order = Order::factory()->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
                'warehouse_id' => $warehouse->id,
            ]);

            expect($order->warehouse)->toBeInstanceOf(Warehouse::class)
                ->and($order->warehouse->id)->toBe($warehouse->id);
        });

        test("peut décrémenter les stocks de tous les produits de la commande", function () {
            $warehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
            $product1 = Product::factory()->create(['company_id' => $this->company->id]);
            $product2 = Product::factory()->create(['company_id' => $this->company->id]);

            $warehouse->updateProductStock($product1, 10);
            $warehouse->updateProductStock($product2, 5);

            $order = Order::factory()->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
                'warehouse_id' => $warehouse->id,
            ]);

            $order->products()->attach($product1->id, ['quantity' => 3, 'unit_price' => 50, 'total_price' => 150]);
            $order->products()->attach($product2->id, ['quantity' => 2, 'unit_price' => 75, 'total_price' => 150]);

            $order->refresh();

            expect($warehouse->getProductStock($product1))->toBe(10)
                ->and($warehouse->getProductStock($product2))->toBe(5);

            $result = $order->decreaseStocks();

            expect($result)->toBeTrue()
                ->and($warehouse->fresh()->getProductStock($product1))->toBe(7)
                ->and($warehouse->fresh()->getProductStock($product2))->toBe(3);
        });

        test('retourne false si stock insuffisant lors de la décrémentation', function () {
            $warehouse = Warehouse::factory()->create([
                'company_id' => $this->company->id,
            ]);

            $product1 = Product::factory()->create([
                'company_id' => $this->company->id,
            ]);

            // Ajouter un stock insuffisant dans l'entrepôt
            $warehouse->updateProductStock($product1, 2);

            $order = Order::factory()->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
                'warehouse_id' => $warehouse->id,
            ]);

            // Ajouter un produit avec une quantité supérieure au stock
            $order->products()->attach($product1->id, [
                'quantity' => 5, // Plus que le stock disponible (2)
                'unit_price' => 50.00,
                'total_price' => 250.00,
            ]);

            // Vérifier que la décrémentation échoue
            $result = $order->decreaseStocks();

            expect($result)->toBeFalse()
                ->and($warehouse->fresh()->getProductStock($product1))->toBe(2); // Stock inchangé
        });

        test("retourne false si aucun entrepôt n'est sélectionné pour la décrémentation", function () {
            $order = Order::factory()->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
                'warehouse_id' => null, // Pas d'entrepôt
            ]);

            $result = $order->decreaseStocks();

            expect($result)->toBeFalse();
        });

        test("peut vérifier si tous les produits ont suffisamment de stock dans l'entrepôt", function () {
            $warehouse = Warehouse::factory()->create([
                'company_id' => $this->company->id,
            ]);

            $product1 = Product::factory()->create([
                'company_id' => $this->company->id,
            ]);

            $product2 = Product::factory()->create([
                'company_id' => $this->company->id,
            ]);

            // Ajouter des stocks dans l'entrepôt
            $warehouse->updateProductStock($product1, 10);
            $warehouse->updateProductStock($product2, 5);

            $order = Order::factory()->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
                'warehouse_id' => $warehouse->id,
            ]);

            // Ajouter des produits à la commande avec des quantités disponibles
            $order->products()->attach($product1->id, [
                'quantity' => 3,
                'unit_price' => 50.00,
                'total_price' => 150.00,
            ]);

            $order->products()->attach($product2->id, [
                'quantity' => 2,
                'unit_price' => 75.00,
                'total_price' => 150.00,
            ]);

            expect($order->canFulfillFromWarehouse())->toBeTrue();
        });

        test("retourne false si un produit n'a pas suffisamment de stock dans l'entrepôt", function () {
            $warehouse = Warehouse::factory()->create([
                'company_id' => $this->company->id,
            ]);

            $product1 = Product::factory()->create([
                'company_id' => $this->company->id,
            ]);

            $product2 = Product::factory()->create([
                'company_id' => $this->company->id,
            ]);

            // Ajouter des stocks insuffisants dans l'entrepôt
            $warehouse->updateProductStock($product1, 2); // Stock insuffisant
            $warehouse->updateProductStock($product2, 5);

            $order = Order::factory()->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
                'warehouse_id' => $warehouse->id,
            ]);

            // Ajouter des produits à la commande avec des quantités supérieures au stock
            $order->products()->attach($product1->id, [
                'quantity' => 5, // Plus que le stock disponible (2)
                'unit_price' => 50.00,
                'total_price' => 250.00,
            ]);

            $order->products()->attach($product2->id, [
                'quantity' => 2,
                'unit_price' => 75.00,
                'total_price' => 150.00,
            ]);

            expect($order->canFulfillFromWarehouse())->toBeFalse();
        });

        test("retourne false si aucun entrepôt n'est sélectionné", function () {
            $order = Order::factory()->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
                'warehouse_id' => null, // Pas d'entrepôt
            ]);

            expect($order->canFulfillFromWarehouse())->toBeFalse();
        });
    });

    // 
    
});
