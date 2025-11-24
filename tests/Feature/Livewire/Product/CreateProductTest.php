<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Member;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Livewire\Livewire;
use App\Livewire\Dashboard\Products\Create;

beforeEach(function () {
    $this->company = Company::factory()->create();

    $this->user = User::factory()
        ->has(Member::factory()->state([
            'company_id' => $this->company->id
        ]))
        ->create();

    $this->company->load('warehouses');
    $this->user->load('member');

    $this->actingAs($this->user);

    $this->defaultWarehouse = Warehouse::factory()
        ->for($this->company)
        ->create(['default' => true]);
    
    $this->otherWarehouse = Warehouse::factory()
        ->for($this->company)
        ->create(['default' => false]);
});

test("ajoute correctement une ligne d'entrepôt par défaut", function () {
    Livewire::test(Create::class, ['tenant' => $this->company])
        ->assertSet('warehouseLines.0.warehouse_id', $this->defaultWarehouse->id)
        ->assertSet('warehouseLines.0.quantity', 0)
        ->call('addWarehouseLine') // Ajouter une seconde ligne
        ->assertSet('warehouseLines', function ($lines) {
            return count($lines) === 2 && 
                $lines[1]['warehouse_id'] === $this->defaultWarehouse->id;
        });
});

test("supprime une ligne d'entrepôt et recalcule le total", function () {
    Livewire::test(Create::class, ['tenant' => $this->company])
        ->set('warehouseLines', [
            ['warehouse_id' => $this->defaultWarehouse->id, 'quantity' => 10],
            ['warehouse_id' => $this->otherWarehouse->id, 'quantity' => 5],
        ])
        ->set('totalWarehouseQuantity', 15)
        ->call('removeWarehouseLine', 0)
        ->assertSet('warehouseLines', function ($lines) {
            // Vérifier que la première ligne a disparu et que l'index 0 est maintenant la deuxième ligne
            return count($lines) === 1 && $lines[0]['warehouse_id'] === $this->otherWarehouse->id;
        })
        // 3. Vérifier que la méthode de recalcul a été appelée
        ->assertSet('totalWarehouseQuantity', 5); // Si la ligne 10 a été retirée
});

/* test('peut créer un produit avec un entrepôt et une quantité', function () {
    // Créer une entreprise et un entrepôt
    $company = Company::factory()->create();
    $warehouse = Warehouse::factory()->create([
        'company_id' => $company->id,
        'default' => true
    ]);

    // Créer un fichier image temporaire pour le test
    $image = \Illuminate\Http\UploadedFile::fake()->image('test.jpg', 100, 100);

    // Simuler la création d'un produit via Livewire
    $component = Livewire::test(Create::class, ['tenant' => $company])
        ->set('name', 'Produit Test')
        ->set('description', 'Description du produit test')
        ->set('price', '25.50')
        ->set('warehouse_id', $warehouse->id)
        ->set('warehouse_quantity', '15')
        ->set('featured_image', $image)
        ->call('save');

    // Vérifier qu'il n'y a pas d'erreurs
    expect($component->get('errors'))->toBeEmpty();

    // Vérifier que le produit a été créé
    $product = Product::where('name', 'Produit Test')->first();
    expect($product)->not->toBeNull();
    expect($product->company_id)->toBe($company->id);
    expect($product->stock_quantity)->toBe(15);

    // Vérifier que l'association avec l'entrepôt a été créée
    $warehouseProduct = WarehouseProduct::where('warehouse_id', $warehouse->id)
        ->where('product_id', $product->id)
        ->first();
    
    expect($warehouseProduct)->not->toBeNull();
    expect($warehouseProduct->quantity)->toBe(15);
}); */

/* test('pré-sélectionne l\'entrepôt par défaut', function () {
    $company = Company::factory()->create();
    $defaultWarehouse = Warehouse::factory()->create([
        'company_id' => $company->id,
        'default' => true
    ]);
    $otherWarehouse = Warehouse::factory()->create([
        'company_id' => $company->id,
        'default' => false
    ]);

    $component = Livewire::test(Create::class, ['tenant' => $company]);
    
    expect($component->get('warehouse_id'))->toBe($defaultWarehouse->id);
}); */

/* test('prend le premier entrepôt si aucun par défaut', function () {
    $company = Company::factory()->create();
    $warehouse1 = Warehouse::factory()->create([
        'company_id' => $company->id,
        'default' => false
    ]);
    $warehouse2 = Warehouse::factory()->create([
        'company_id' => $company->id,
        'default' => false
    ]);

    $component = Livewire::test(Create::class, ['tenant' => $company]);
    
    // Devrait prendre le premier entrepôt (par ordre de création)
    expect($component->get('warehouse_id'))->toBe($warehouse1->id);
}); */

/* test('recalcule automatiquement le stock total', function () {
    $company = Company::factory()->create();
    $warehouse1 = Warehouse::factory()->create(['company_id' => $company->id]);
    $warehouse2 = Warehouse::factory()->create(['company_id' => $company->id]);

    // Créer un produit
    $product = Product::factory()->create([
        'company_id' => $company->id,
        'stock_quantity' => 0
    ]);

    // Ajouter du stock dans le premier entrepôt
    $warehouse1->updateProductStock($product, 10);
    $product->refresh();
    expect($product->stock_quantity)->toBe(10);

    // Ajouter du stock dans le deuxième entrepôt
    $warehouse2->updateProductStock($product, 5);
    $product->refresh();
    expect($product->stock_quantity)->toBe(15);

    // Vérifier les quantités dans chaque entrepôt
    expect($warehouse1->getProductStock($product))->toBe(10);
    expect($warehouse2->getProductStock($product))->toBe(5);
}); */
