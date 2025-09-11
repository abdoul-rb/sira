<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->warehouse = Warehouse::factory()->create([
        'company_id' => $this->company->id,
    ]);

    $this->product = Product::factory()->create([
        'company_id' => $this->company->id,
    ]);
    
    $this->warehouseProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $this->product->id,
        'quantity' => 10,
    ]);
});

/*
|--------------------------------------------------------------------------
| Tests de base du modèle
|--------------------------------------------------------------------------
*/

test('WarehouseProduct: colonnes attendues du modèle', function () {
    // Vérifier que le modèle WarehouseProduct contient toutes les colonnes attendues
    $warehouseProduct = WarehouseProduct::factory()->create()->fresh();

    expect(array_keys($warehouseProduct->toArray()))->toBe([
        'id',
        'warehouse_id',
        'product_id',
        'quantity',
        'created_at',
        'updated_at',
    ]);
});

test('WarehouseProduct: attributs modifiables', function () {
    // Vérifier que seuls les attributs autorisés peuvent être assignés en masse
    $warehouseProduct = new WarehouseProduct();
    
    expect($warehouseProduct->getFillable())->toBe([
        'warehouse_id',
        'product_id',
        'quantity',
    ]);
});

test('WarehouseProduct: conversion des attributs', function () {
    // Vérifier que les attributs sont correctement castés (ex: integer pour 'quantity')
    $warehouseProduct = WarehouseProduct::factory()->create(['quantity' => 15]);
    
    expect($warehouseProduct->quantity)->toBe(15);
    expect($warehouseProduct->getCasts())->toHaveKey('quantity', 'integer');
});

/*
|--------------------------------------------------------------------------
| Tests des relations
|--------------------------------------------------------------------------
*/

test('WarehouseProduct: appartient à un entrepôt', function () {
    // Vérifier qu'un produit d'entrepôt appartient à un entrepôt
    $warehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $warehouseProduct = WarehouseProduct::factory()->create(['warehouse_id' => $warehouse->id]);
    
    expect($warehouseProduct->warehouse)->toBeInstanceOf(Warehouse::class);
    expect($warehouseProduct->warehouse->id)->toBe($warehouse->id);
});

test('WarehouseProduct: appartient à un produit', function () {
    // Vérifier qu'un produit d'entrepôt appartient à un produit
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    $warehouseProduct = WarehouseProduct::factory()->create(['product_id' => $product->id]);
    
    expect($warehouseProduct->product)->toBeInstanceOf(Product::class);
    expect($warehouseProduct->product->id)->toBe($product->id);
});

/*
|--------------------------------------------------------------------------
| Tests des scopes
|--------------------------------------------------------------------------
*/

test('WarehouseProduct: filtre les produits en stock', function () {
    // Vérifier que le scope inStock filtre correctement les produits avec quantité > 0
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $inStockProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id,
        'quantity' => 5
    ]);
    
    $outOfStockProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => Product::factory()->create(['company_id' => $this->company->id])->id,
        'quantity' => 0
    ]);
    
    $inStockProducts = WarehouseProduct::inStock()->get();
    
    expect($inStockProducts)->toHaveCount(2); // inStockProduct + this->warehouseProduct (quantity: 10)
    expect($inStockProducts->pluck('id')->toArray())->toContain($inStockProduct->id, $this->warehouseProduct->id);
});

test('WarehouseProduct: filtre par entrepôt', function () {
    // Vérifier que le scope forWarehouse filtre correctement les produits d'un entrepôt
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $warehouseProduct2 = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id
    ]);
    
    $warehouseProducts = WarehouseProduct::forWarehouse($this->warehouse->id)->get();
    
    expect($warehouseProducts)->toHaveCount(1);
    expect($warehouseProducts->first()->id)->toBe($this->warehouseProduct->id);
});

test('WarehouseProduct: filtre par produit', function () {
    // Vérifier que le scope forProduct filtre correctement les entrepôts d'un produit
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    
    $warehouseProduct2 = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id
    ]);
    
    $warehouseProducts = WarehouseProduct::forProduct($this->product->id)->get();
    
    expect($warehouseProducts)->toHaveCount(1);
    expect($warehouseProducts->first()->id)->toBe($this->warehouseProduct->id);
});

/*
|--------------------------------------------------------------------------
| Tests des méthodes de gestion de quantité
|--------------------------------------------------------------------------
*/

test('WarehouseProduct: décrémente la quantité avec stock suffisant', function () {
    // Vérifier qu'on peut décrémenter la quantité quand elle est suffisante
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $warehouseProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id,
        'quantity' => 20
    ]);
    
    $result = $warehouseProduct->decreaseQuantity(5);
    
    expect($result)->toBeTrue();
    $warehouseProduct->refresh();
    expect($warehouseProduct->quantity)->toBe(15);
});

test('WarehouseProduct: refuse de décrémenter une quantité insuffisante', function () {
    // Vérifier qu'on ne peut pas décrémenter plus que la quantité disponible
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $warehouseProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id,
        'quantity' => 5
    ]);
    
    $result = $warehouseProduct->decreaseQuantity(10);
    
    expect($result)->toBeFalse();
    $warehouseProduct->refresh();
    // La quantité ne doit pas avoir changé
    expect($warehouseProduct->quantity)->toBe(5);
});

test('WarehouseProduct: augmente la quantité', function () {
    // Vérifier qu'on peut augmenter la quantité de stock
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $warehouseProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id,
        'quantity' => 10
    ]);
    
    $warehouseProduct->increaseQuantity(5);
    
    $warehouseProduct->refresh();
    expect($warehouseProduct->quantity)->toBe(15);
});

test('WarehouseProduct: met à jour la quantité', function () {
    // Vérifier qu'on peut mettre à jour la quantité de stock
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $warehouseProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id,
        'quantity' => 10
    ]);
    
    $warehouseProduct->updateQuantity(25);
    
    $warehouseProduct->refresh();
    expect($warehouseProduct->quantity)->toBe(25);
});

/*
|--------------------------------------------------------------------------
| Tests des cas d'usage métier
|--------------------------------------------------------------------------
*/

test('WarehouseProduct: gestion de quantité avec valeurs limites', function () {
    // Vérifier les cas limites de gestion de quantité
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $warehouseProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id,
        'quantity' => 0
    ]);
    
    // Test avec quantité zéro
    expect($warehouseProduct->quantity)->toBe(0);
    
    // Test de décrémentation avec quantité zéro
    $result = $warehouseProduct->decreaseQuantity(1);
    expect($result)->toBeFalse();
    expect($warehouseProduct->quantity)->toBe(0);
    
    // Test d'augmentation depuis zéro
    $warehouseProduct->increaseQuantity(5);
    $warehouseProduct->refresh();
    expect($warehouseProduct->quantity)->toBe(5);
});

test('WarehouseProduct: opérations de quantité atomiques', function () {
    // Vérifier que les opérations de quantité sont atomiques
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $warehouseProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id,
        'quantity' => 100
    ]);
    
    // Décrémenter puis augmenter
    $warehouseProduct->decreaseQuantity(30);
    $warehouseProduct->refresh();
    expect($warehouseProduct->quantity)->toBe(70);
    
    $warehouseProduct->increaseQuantity(20);
    $warehouseProduct->refresh();
    expect($warehouseProduct->quantity)->toBe(90);
    
    // Mise à jour directe
    $warehouseProduct->updateQuantity(50);
    $warehouseProduct->refresh();
    expect($warehouseProduct->quantity)->toBe(50);
});

test('WarehouseProduct: unicité par entrepôt et produit', function () {
    // Vérifier qu'il ne peut y avoir qu'un seul enregistrement par combinaison entrepôt/produit
    // Le warehouseProduct de beforeEach existe déjà avec cette combinaison
    expect($this->warehouseProduct->warehouse_id)->toBe($this->warehouse->id);
    expect($this->warehouseProduct->product_id)->toBe($this->product->id);
    
    // Tenter de créer un doublon (devrait échouer au niveau de la base de données)
    expect(function () {
        WarehouseProduct::factory()->create([
            'warehouse_id' => $this->warehouse->id,
            'product_id' => $this->product->id,
            'quantity' => 20
        ]);
    })->toThrow(Exception::class);
});

test('WarehouseProduct: factory génère des données valides', function () {
    // Vérifier que la factory génère des données valides pour les tests
    $warehouseProduct = WarehouseProduct::factory()->create();
    
    expect($warehouseProduct->warehouse_id)->toBeInt();
    expect($warehouseProduct->product_id)->toBeInt();
    expect($warehouseProduct->quantity)->toBeInt();
    expect($warehouseProduct->quantity)->toBeGreaterThanOrEqual(0);
});

test('WarehouseProduct: relations fonctionnent correctement', function () {
    // Vérifier que les relations sont correctement chargées
    $warehouseProduct = WarehouseProduct::with(['warehouse', 'product'])->find($this->warehouseProduct->id);
    
    expect($warehouseProduct->warehouse)->not->toBeNull();
    expect($warehouseProduct->product)->not->toBeNull();
    expect($warehouseProduct->warehouse)->toBeInstanceOf(Warehouse::class);
    expect($warehouseProduct->product)->toBeInstanceOf(Product::class);
});

test('WarehouseProduct: scopes combinés fonctionnent', function () {
    // Vérifier que les scopes peuvent être combinés
    $otherWarehouse = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $otherProduct = Product::factory()->create(['company_id' => $this->company->id]);
    
    $inStockProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => $otherProduct->id,
        'quantity' => 5
    ]);
    
    $outOfStockProduct = WarehouseProduct::factory()->create([
        'warehouse_id' => $otherWarehouse->id,
        'product_id' => Product::factory()->create(['company_id' => $this->company->id])->id,
        'quantity' => 0
    ]);
    
    // Combiner les scopes
    $results = WarehouseProduct::forWarehouse($otherWarehouse->id)
        ->inStock()
        ->get();
    
    expect($results)->toHaveCount(1);
    expect($results->first()->id)->toBe($inStockProduct->id);
});
