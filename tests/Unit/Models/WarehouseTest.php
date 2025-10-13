<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->warehouse = Warehouse::factory()->create([
        'company_id' => $this->company->id,
    ]);
});

/*
|--------------------------------------------------------------------------
| Tests de base du modèle
|--------------------------------------------------------------------------
*/

test('Warehouse: array expected columns', function () {
    // Vérifier que le modèle Warehouse contient toutes les colonnes attendues
    $warehouse = Warehouse::factory()->create()->fresh();

    expect(array_keys($warehouse->toArray()))->toBe([
        'id',
        'company_id',
        'name',
        'location',
        'default',
        'created_at',
        'updated_at',
    ]);
});

test('Warehouse: fillable attributes', function () {
    // Vérifier que seuls les attributs autorisés peuvent être assignés en masse
    $warehouse = new Warehouse();
    
    expect($warehouse->getFillable())->toBe([
        'company_id',
        'name',
        'location',
        'default',
    ]);
});

test('Warehouse: casts attributes', function () {
    // Vérifier que les attributs sont correctement castés (ex: boolean pour 'default')
    $warehouse = Warehouse::factory()->create(['default' => true]);
    
    expect($warehouse->default)->toBeTrue();
    expect($warehouse->getCasts())->toHaveKey('default', 'boolean');
});

/*
|--------------------------------------------------------------------------
| Tests des relations
|--------------------------------------------------------------------------
*/

test('Warehouse: belongs to company', function () {
    // Vérifier qu'un entrepôt appartient à une entreprise
    $company = Company::factory()->create();
    $warehouse = Warehouse::factory()->create(['company_id' => $company->id]);
    
    expect($warehouse->company)->toBeInstanceOf(Company::class);
    expect($warehouse->company->id)->toBe($company->id);
});

test('Warehouse: has many warehouse products', function () {
    // Vérifier qu'un entrepôt peut contenir plusieurs produits avec leurs quantités
    $product1 = Product::factory()->create(['company_id' => $this->company->id]);
    $product2 = Product::factory()->create(['company_id' => $this->company->id]);
    
    WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $product1->id,
        'quantity' => 10
    ]);
    
    WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $product2->id,
        'quantity' => 5
    ]);
    
    expect($this->warehouse->warehouseProducts)->toHaveCount(2);
    expect($this->warehouse->warehouseProducts->first())->toBeInstanceOf(WarehouseProduct::class);
});

test('Warehouse: has many orders', function () {
    // Vérifier qu'un entrepôt peut avoir plusieurs commandes
    $order1 = Order::factory()->create([
        'company_id' => $this->company->id,
        'warehouse_id' => $this->warehouse->id
    ]);
    
    $order2 = Order::factory()->create([
        'company_id' => $this->company->id,
        'warehouse_id' => $this->warehouse->id
    ]);
    
    expect($this->warehouse->orders)->toHaveCount(2);
    expect($this->warehouse->orders->first())->toBeInstanceOf(Order::class);
});

/*
|--------------------------------------------------------------------------
| Tests des scopes
|--------------------------------------------------------------------------
*/

test('Warehouse: scope default', function () {
    // Vérifier que le scope default filtre correctement les entrepôts par défaut
    $defaultWarehouse = Warehouse::factory()->create([
        'company_id' => $this->company->id,
        'default' => true
    ]);
    
    $nonDefaultWarehouse = Warehouse::factory()->create([
        'company_id' => $this->company->id,
        'default' => false
    ]);
    
    // S'assurer que l'entrepôt de beforeEach n'est pas par défaut
    $this->warehouse->update(['default' => false]);
    
    $defaultWarehouses = Warehouse::default()->get();
    
    expect($defaultWarehouses)->toHaveCount(1);
    expect($defaultWarehouses->first()->id)->toBe($defaultWarehouse->id);
});

test('Warehouse: scope for company', function () {
    // Vérifier que le scope forCompany filtre correctement les entrepôts d'une entreprise
    $otherCompany = Company::factory()->create();
    
    $warehouse1 = Warehouse::factory()->create(['company_id' => $this->company->id]);
    $warehouse2 = Warehouse::factory()->create(['company_id' => $otherCompany->id]);
    
    // S'assurer que l'entrepôt de beforeEach appartient à la même entreprise
    $this->warehouse->update(['company_id' => $this->company->id]);
    
    $companyWarehouses = Warehouse::forCompany($this->company->id)->get();
    
    expect($companyWarehouses)->toHaveCount(2); // warehouse1 + this->warehouse
    expect($companyWarehouses->pluck('id')->toArray())->toContain($warehouse1->id, $this->warehouse->id);
});

/*
|--------------------------------------------------------------------------
| Tests des méthodes de gestion de stock
|--------------------------------------------------------------------------
*/

test('Warehouse: get product stock when product exists', function () {
    // Vérifier qu'on peut récupérer le stock d'un produit existant dans l'entrepôt
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $product->id,
        'quantity' => 15
    ]);
    
    $stock = $this->warehouse->getProductStock($product);
    
    expect($stock)->toBe(15);
});

test('Warehouse: get product stock when product does not exist', function () {
    // Vérifier qu'on retourne 0 quand un produit n'existe pas dans l'entrepôt
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    $stock = $this->warehouse->getProductStock($product);
    
    expect($stock)->toBe(0);
});

test('Warehouse: update product stock creates new record', function () {
    // Vérifier qu'on peut créer un nouveau stock pour un produit
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    $this->warehouse->updateProductStock($product, 20);
    
    $warehouseProduct = WarehouseProduct::where('warehouse_id', $this->warehouse->id)
        ->where('product_id', $product->id)
        ->first();
    
    expect($warehouseProduct)->not->toBeNull();
    expect($warehouseProduct->quantity)->toBe(20);
});

test('Warehouse: update product stock updates existing record', function () {
    // Vérifier qu'on peut mettre à jour le stock d'un produit existant
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    // Créer un stock initial
    WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $product->id,
        'quantity' => 10
    ]);
    
    // Mettre à jour le stock
    $this->warehouse->updateProductStock($product, 25);
    
    $warehouseProduct = WarehouseProduct::where('warehouse_id', $this->warehouse->id)
        ->where('product_id', $product->id)
        ->first();
    
    expect($warehouseProduct->quantity)->toBe(25);
});

test('Warehouse: decrease product stock with sufficient stock', function () {
    // Vérifier qu'on peut décrémenter le stock quand il est suffisant
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $product->id,
        'quantity' => 20
    ]);
    
    $result = $this->warehouse->decreaseProductStock($product, 5);
    
    expect($result)->toBeTrue();
    
    $warehouseProduct = WarehouseProduct::where('warehouse_id', $this->warehouse->id)
        ->where('product_id', $product->id)
        ->first();
    
    expect($warehouseProduct->quantity)->toBe(15);
});

test('Warehouse: decrease product stock with insufficient stock', function () {
    // Vérifier qu'on ne peut pas décrémenter plus que le stock disponible
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $product->id,
        'quantity' => 5
    ]);
    
    $result = $this->warehouse->decreaseProductStock($product, 10);
    
    expect($result)->toBeFalse();
    
    $warehouseProduct = WarehouseProduct::where('warehouse_id', $this->warehouse->id)
        ->where('product_id', $product->id)
        ->first();
    
    // La quantité ne doit pas avoir changé
    expect($warehouseProduct->quantity)->toBe(5);
});

test('Warehouse: decrease product stock when product does not exist', function () {
    // Vérifier qu'on ne peut pas décrémenter le stock d'un produit inexistant
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    $result = $this->warehouse->decreaseProductStock($product, 5);
    
    expect($result)->toBeFalse();
});

test('Warehouse: has sufficient stock when stock is sufficient', function () {
    // Vérifier qu'on peut vérifier la disponibilité d'un stock suffisant
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $product->id,
        'quantity' => 20
    ]);
    
    $hasStock = $this->warehouse->hasSufficientStock($product, 15);
    
    expect($hasStock)->toBeTrue();
});

test('Warehouse: has sufficient stock when stock is insufficient', function () {
    // Vérifier qu'on détecte correctement un stock insuffisant
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    WarehouseProduct::factory()->create([
        'warehouse_id' => $this->warehouse->id,
        'product_id' => $product->id,
        'quantity' => 10
    ]);
    
    $hasStock = $this->warehouse->hasSufficientStock($product, 15);
    
    expect($hasStock)->toBeFalse();
});

test('Warehouse: has sufficient stock when product does not exist', function () {
    // Vérifier qu'un produit inexistant n'a pas de stock suffisant
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    $hasStock = $this->warehouse->hasSufficientStock($product, 5);
    
    expect($hasStock)->toBeFalse();
});

/*
|--------------------------------------------------------------------------
| Tests de la méthode markAsDefault
|--------------------------------------------------------------------------
*/

test('Warehouse: mark as default when no other default exists', function () {
    // Vérifier qu'on peut marquer un entrepôt comme défaut quand aucun autre n'existe
    $warehouse = Warehouse::factory()->create([
        'company_id' => $this->company->id,
        'default' => false
    ]);
    
    $warehouse->markAsDefault();
    
    $warehouse->refresh();
    expect($warehouse->default)->toBeTrue();
});

test('Warehouse: mark as default removes default from other warehouses', function () {
    // Vérifier qu'on ne peut avoir qu'un seul entrepôt par défaut par entreprise
    $existingDefault = Warehouse::factory()->create([
        'company_id' => $this->company->id,
        'default' => true
    ]);
    
    // Créer un nouvel entrepôt
    $newWarehouse = Warehouse::factory()->create([
        'company_id' => $this->company->id,
        'default' => false
    ]);
    
    // Marquer le nouvel entrepôt comme par défaut
    $newWarehouse->markAsDefault();
    
    // Vérifier que l'ancien entrepôt n'est plus par défaut
    $existingDefault->refresh();
    expect($existingDefault->default)->toBeFalse();
    
    // Vérifier que le nouvel entrepôt est par défaut
    $newWarehouse->refresh();
    expect($newWarehouse->default)->toBeTrue();
});

test('Warehouse: mark as default only affects same company', function () {
    // Vérifier que les entrepôts par défaut sont isolés par entreprise
    $otherCompany = Company::factory()->create();
    
    // Créer un entrepôt par défaut pour une autre entreprise
    $otherCompanyDefault = Warehouse::factory()->create([
        'company_id' => $otherCompany->id,
        'default' => true
    ]);
    
    // Créer un entrepôt pour notre entreprise
    $ourWarehouse = Warehouse::factory()->create([
        'company_id' => $this->company->id,
        'default' => false
    ]);
    
    // Marquer notre entrepôt comme par défaut
    $ourWarehouse->markAsDefault();
    
    // Vérifier que l'entrepôt de l'autre entreprise reste par défaut
    $otherCompanyDefault->refresh();
    expect($otherCompanyDefault->default)->toBeTrue();
    
    // Vérifier que notre entrepôt est par défaut
    $ourWarehouse->refresh();
    expect($ourWarehouse->default)->toBeTrue();
});

/*
|--------------------------------------------------------------------------
| Tests des cas d'usage métier
|--------------------------------------------------------------------------
*/

test('Warehouse: cannot have multiple default warehouses for same company', function () {
    // Vérifier la contrainte métier : un seul entrepôt par défaut par entreprise
    $warehouse1 = Warehouse::factory()->create([
        'company_id' => $this->company->id,
        'default' => true
    ]);
    
    // Créer un deuxième entrepôt
    $warehouse2 = Warehouse::factory()->create([
        'company_id' => $this->company->id,
        'default' => false
    ]);
    
    // Marquer le deuxième comme par défaut
    $warehouse2->markAsDefault();
    
    // Vérifier qu'il n'y a qu'un seul entrepôt par défaut
    $defaultWarehouses = Warehouse::where('company_id', $this->company->id)
        ->where('default', true)
        ->count();
    
    expect($defaultWarehouses)->toBe(1);
    expect($warehouse2->fresh()->default)->toBeTrue();
    expect($warehouse1->fresh()->default)->toBeFalse();
});

test('Warehouse: stock management with multiple products', function () {
    // Vérifier que la gestion de stock fonctionne correctement avec plusieurs produits
    $product1 = Product::factory()->create(['company_id' => $this->company->id]);
    $product2 = Product::factory()->create(['company_id' => $this->company->id]);
    
    // Ajouter du stock pour les deux produits
    $this->warehouse->updateProductStock($product1, 10);
    $this->warehouse->updateProductStock($product2, 20);
    
    // Vérifier les stocks
    expect($this->warehouse->getProductStock($product1))->toBe(10);
    expect($this->warehouse->getProductStock($product2))->toBe(20);
    
    // Décrémenter le stock du premier produit
    $this->warehouse->decreaseProductStock($product1, 3);
    
    // Vérifier que seul le premier produit a été affecté
    expect($this->warehouse->getProductStock($product1))->toBe(7);
    expect($this->warehouse->getProductStock($product2))->toBe(20);
});

test('Warehouse: stock validation edge cases', function () {
    // Vérifier les cas limites de gestion de stock (quantités zéro, etc.)
    $product = Product::factory()->create(['company_id' => $this->company->id]);
    
    // Test avec quantité zéro
    $this->warehouse->updateProductStock($product, 0);
    expect($this->warehouse->getProductStock($product))->toBe(0);
    expect($this->warehouse->hasSufficientStock($product, 0))->toBeTrue();
    expect($this->warehouse->hasSufficientStock($product, 1))->toBeFalse();
    
    // Test de décrémentation avec quantité zéro
    $result = $this->warehouse->decreaseProductStock($product, 1);
    expect($result)->toBeFalse();
    expect($this->warehouse->getProductStock($product))->toBe(0);
});

test('Warehouse: warehouse with orders relationship', function () {
    // Vérifier que la relation avec les commandes fonctionne correctement
    $order1 = Order::factory()->create([
        'company_id' => $this->company->id,
        'warehouse_id' => $this->warehouse->id
    ]);
    
    $order2 = Order::factory()->create([
        'company_id' => $this->company->id,
        'warehouse_id' => $this->warehouse->id
    ]);
    
    // Vérifier la relation
    expect($this->warehouse->orders)->toHaveCount(2);
    expect($this->warehouse->orders->pluck('id')->toArray())->toContain($order1->id, $order2->id);
});

test('Warehouse: factory creates valid warehouse', function () {
    // Vérifier que la factory génère des données valides pour les tests
    $warehouse = Warehouse::factory()->create();
    
    expect($warehouse->name)->not->toBeEmpty();
    expect($warehouse->company_id)->toBeInt();
    expect($warehouse->default)->toBeIn([true, false]);
});

