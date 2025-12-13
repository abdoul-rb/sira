<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Member;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use Livewire\Livewire;
use App\Livewire\Dashboard\Products\Create;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

beforeEach(function () {
    /** @var TestCase $this */
    $this->company = Company::factory()->create();

    /** @var TestCase $this */
    $this->user = User::factory()
        ->has(Member::factory()->state([
            'company_id' => $this->company->id
        ]))
        ->create();

    // Créer et assigner la permission 'create-product' à l'utilisateur
    $permission = Permission::firstOrCreate(['name' => 'create-product']);
    $this->user->givePermissionTo($permission);

    $this->company->load('warehouses');
    $this->user->load('member');

    $this->actingAs($this->user);

    /** @var TestCase $this */
    $this->defaultWarehouse = Warehouse::factory()
        ->for($this->company)
        ->create(['default' => true]);
    
    /** @var TestCase $this */
    $this->otherWarehouse = Warehouse::factory()
        ->for($this->company)
        ->create(['default' => false]);
});

describe('Trait ManagesProductWarehouses', function () {
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
            // Vérifier que la méthode de recalcul a été appelée
            ->assertSet('totalWarehouseQuantity', 5); // Si la ligne 10 a été retirée
    });

    test("recalcule le total quand une quantité change", function () {
        Livewire::test(Create::class, ['tenant' => $this->company])
            ->set('warehouseLines.0.quantity', 10)
            ->assertSet('totalWarehouseQuantity', 10)
            ->call('addWarehouseLine')
            ->set('warehouseLines.1.quantity', 5)
            ->assertSet('totalWarehouseQuantity', 15);
    });

    test("recalcule le total quand les lignes sont réordonnées ou modifiées en masse", function () {
        Livewire::test(Create::class, ['tenant' => $this->company])
            ->set('warehouseLines', [
                ['warehouse_id' => $this->defaultWarehouse->id, 'quantity' => 20],
                ['warehouse_id' => $this->otherWarehouse->id, 'quantity' => 30],
            ])
            ->assertSet('totalWarehouseQuantity', 50);
    });

    test("sauvegarde les quantités dans les entrepôts lors de la création du produit", function () {
        $image = \Illuminate\Http\UploadedFile::fake()->image('product.jpg');

        Livewire::test(Create::class, ['tenant' => $this->company])
            ->set('name', 'Produit Test Stock')
            ->set('description', 'Description')
            ->set('price', 100)
            ->set('stockQuantity', 15) // Total attendu
            ->set('featuredImage', $image)
            ->set('warehouseLines', [
                ['warehouse_id' => $this->defaultWarehouse->id, 'quantity' => 10],
                ['warehouse_id' => $this->otherWarehouse->id, 'quantity' => 5],
            ])
            ->call('save')
            ->assertHasNoErrors();

        $product = Product::where('name', 'Produit Test Stock')->first();

        expect($product)->not->toBeNull()
            ->and($product->stock_quantity)->toBe(15)
            ->and($this->defaultWarehouse->getProductStock($product))->toBe(10)
            ->and($this->otherWarehouse->getProductStock($product))->toBe(5);
    });
});

describe('Component Create', function () {
    test('peut créer un produit avec image et stock', function () {
        $image = \Illuminate\Http\UploadedFile::fake()->image('test.jpg');

        Livewire::test(Create::class, ['tenant' => $this->company])
            ->set('name', 'Produit Complet')
            ->set('description', 'Description complète')
            ->set('price', 50)
            ->set('stockQuantity', 10)
            ->set('sku', 'PROD-001')
            ->set('featuredImage', $image)
            ->set('warehouseLines', [
                ['warehouse_id' => $this->defaultWarehouse->id, 'quantity' => 10]
            ])
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('product-created')
            ->assertDispatched('close-modal');

        $product = Product::where('name', 'Produit Complet')->first();
        expect($product)->not->toBeNull()
            ->and($product->sku)->toBe('PROD-001')
            ->and($product->stock_quantity)->toBe(10);
            
        // Vérifier que l'image a été stockée (le chemin exact dépend de la logique de stockage)
        // expect($product->featured_image)->not->toBeNull(); 
    });

    test('valide les champs obligatoires', function () {
        Livewire::test(Create::class, ['tenant' => $this->company])
            ->call('save')
            ->assertHasErrors(['name', 'description', 'price', 'stockQuantity']);
    });

    test('valide l\'unicité du SKU', function () {
        // Créer un produit existant
        Product::factory()->create([
            'company_id' => $this->company->id,
            'sku' => 'EXISTING-SKU'
        ]);

        Livewire::test(Create::class, ['tenant' => $this->company])
            ->set('name', 'Nouveau Produit')
            ->set('description', 'Desc')
            ->set('price', 10)
            ->set('stockQuantity', 1)
            ->set('sku', 'EXISTING-SKU') // SKU dupliqué
            ->call('save')
            ->assertHasErrors(['sku']);
    });

    test('initialise le composant avec un entrepôt par défaut', function () {
        Livewire::test(Create::class, ['tenant' => $this->company])
            ->assertSet('warehouseLines.0.warehouse_id', $this->defaultWarehouse->id);
    });
    
    test('utilise le premier entrepôt si aucun par défaut n\'est défini', function () {
        // Supprimer l'entrepôt par défaut pour ce test
        $this->defaultWarehouse->update(['default' => false]);
        
        Livewire::test(Create::class, ['tenant' => $this->company])
            ->assertSet('warehouseLines.0.warehouse_id', $this->defaultWarehouse->id); // Prend le premier trouvé (defaultWarehouse est créé avant)
    });
});
