<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quotation;

beforeEach(function () {
    $this->company = Company::factory()->create();
});

test('Product: array expected columns', function () {
    $product = Product::factory()->create()->fresh();

    expect(array_keys($product->toArray()))->toBe([
        'id',
        'company_id',
        'name',
        'description',
        'sku',
        'price',
        'stock_quantity',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

describe('Product Model', function () {
    test('peut créer un produtest avec les données de base', function () {
        $product = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($product)
            ->toBeInstanceOf(Product::class)
            ->and($product->company_id)->toBe($this->company->id)
            ->and($product->name)->toBeString()
            ->and($product->price)->toBeGreaterThan(0);
    });

    test('peut créer un produit en stock', function () {
        $product = Product::factory()->inStock()->create([
            'company_id' => $this->company->id,
        ]);

        expect($product->stock_quantity)->toBeGreaterThan(0)
            ->and($product->isInStock())->toBeTrue();
    });

    test('peut créer un produit en rupture de stock', function () {
        $product = Product::factory()->outOfStock()->create([
            'company_id' => $this->company->id,
        ]);

        expect($product->stock_quantity)->toBe(0)
            ->and($product->isInStock())->toBeFalse();
    });

    test('peut mettre à jour le stock', function () {
        $product = Product::factory()->create([
            'company_id' => $this->company->id,
            'stock_quantity' => 10,
        ]);

        $product->updateStock(5);

        expect($product->fresh()->stock_quantity)->toBe(15);
    });

    test('peut diminuer le stock', function () {
        $product = Product::factory()->create([
            'company_id' => $this->company->id,
            'stock_quantity' => 10,
        ]);

        $product->decreaseStock(3);

        expect($product->fresh()->stock_quantity)->toBe(7);
    });

    test('vérifie si le stock est suffisant', function () {
        $product = Product::factory()->create([
            'company_id' => $this->company->id,
            'stock_quantity' => 10,
        ]);

        expect($product->hasSufficientStock(5))->toBeTrue()
            ->and($product->hasSufficientStock(15))->toBeFalse();
    });

    test('appartient à une entreprise', function () {
        $product = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($product->company)->toBeInstanceOf(Company::class)
            ->and($product->company->id)->toBe($this->company->id);
    });

    test('peut avoir des devis associés', function () {
        $product = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $quotation = Quotation::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $product->quotations()->attach($quotation->id, [
            'quantity' => 2,
            'unit_price' => 50.00,
            'total_price' => 100.00,
        ]);

        expect($product->quotations)->toHaveCount(1)
            ->and($product->quotations->first())->toBeInstanceOf(Quotation::class)
            ->and($product->quotations->first()->pivot->quantity)->toBe(2);
    });

    test('peut avoir des commandes associées', function () {
        $product = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $order = Order::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $product->orders()->attach($order->id, [
            'quantity' => 3,
            'unit_price' => 50.00,
            'total_price' => 150.00,
        ]);

        expect($product->orders)->toHaveCount(1)
            ->and($product->orders->first())->toBeInstanceOf(Order::class)
            ->and($product->orders->first()->pivot->quantity)->toBe(3);
    });

    describe('Scopes', function () {
        test('peut filtrer les produits en stock', function () {
            Product::factory()->inStock()->count(4)->create([
                'company_id' => $this->company->id,
            ]);
            Product::factory()->outOfStock()->count(1)->create([
                'company_id' => $this->company->id,
            ]);

            $inStockProducts = Product::inStock()->get();

            expect($inStockProducts)->toHaveCount(4)
                ->and($inStockProducts->every(fn ($product) => $product->isInStock()))->toBeTrue();
        });
    });
});
