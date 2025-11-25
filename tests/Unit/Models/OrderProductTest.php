<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->order = Order::factory()->create(['company_id' => $this->company->id]);
    $this->product = Product::factory()->create(['company_id' => $this->company->id]);
});

test('OrderProduct: array expected columns', function () {
    $orderProduct = new OrderProduct();
    
    // On simule un modèle hydraté pour vérifier les clés
    $orderProduct->setRawAttributes([
        'id' => 1,
        'order_id' => 1,
        'product_id' => 1,
        'quantity' => 1,
        'unit_price' => '10.00',
        'total_price' => '10.00',
        'notes' => 'Test note',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    expect(array_keys($orderProduct->toArray()))->toBe([
        'id',
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
        'notes',
        'created_at',
        'updated_at',
    ]);
});

describe('OrderProduct Model', function () {
    test('peut créer un order_product', function () {
        $orderProduct = OrderProduct::create([
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
            'unit_price' => 50.00,
            'total_price' => 100.00,
            'notes' => 'Test note',
        ]);

        expect($orderProduct)
            ->toBeInstanceOf(OrderProduct::class)
            ->and($orderProduct->order_id)->toBe($this->order->id)
            ->and($orderProduct->product_id)->toBe($this->product->id)
            ->and($orderProduct->quantity)->toBe(2)
            ->and($orderProduct->unit_price)->toBe('50.00')
            ->and($orderProduct->total_price)->toBe('100.00')
            ->and($orderProduct->notes)->toBe('Test note');
    });

    test('appartient à une commande', function () {
        $orderProduct = OrderProduct::create([
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'unit_price' => 10.00,
            'total_price' => 10.00,
        ]);

        expect($orderProduct->order)->toBeInstanceOf(Order::class)
            ->and($orderProduct->order->id)->toBe($this->order->id);
    });

    test('appartient à un produit', function () {
        $orderProduct = OrderProduct::create([
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'unit_price' => 10.00,
            'total_price' => 10.00,
        ]);

        expect($orderProduct->product)->toBeInstanceOf(Product::class)
            ->and($orderProduct->product->id)->toBe($this->product->id);
    });

    test('casts attributes correctly', function () {
        $orderProduct = OrderProduct::create([
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'quantity' => '5', // String input
            'unit_price' => 10.5, // Float input
            'total_price' => 52.5, // Float input
        ]);

        $orderProduct->refresh();

        expect($orderProduct->quantity)->toBeInt()->toBe(5)
            ->and($orderProduct->unit_price)->toBeString()->toBe('10.50') // decimal:2 cast returns string
            ->and($orderProduct->total_price)->toBeString()->toBe('52.50');
    });
});
