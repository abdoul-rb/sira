<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Product;
use App\Actions\Product\CreateAction as CreateProductAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->action = app(CreateProductAction::class);

    Storage::fake('public');

    $this->baseData = [
        'name' => 'Laptop Pro',
        'description' => 'Un super laptop.',
        'sku' => 'SKU-LPRO-001',
        'price' => 1499.99,
        'stock_quantity' => 50,
    ];
});

describe('CreateProductAction', function () {
    test('create and return a product', function () {
        $product = $this->action->handle($this->company, $this->baseData);

        expect($product)->toBeInstanceOf(Product::class)
            ->and($product->company_id)->toBe($this->company->id)
            ->and($product->slug)->toBeString()
            ->and($product->name)->toBe('Laptop Pro')
            ->and($product->description)->toBe('Un super laptop.')
            ->and($product->price)->toBe(1499.99)
            ->and($product->stock_quantity)->toBe(50)
            ->and($product->featured_image)->toBeNull(); 

        $this->assertDatabaseHas('products', [
            'name' => 'Laptop Pro',
            'description' => 'Un super laptop.',
            'sku' => 'SKU-LPRO-001',
            'price' => 1499.99,
            'stock_quantity' => 50,
            'featured_image' => null,
        ]);
        
        expect(Product::count())->toBe(1);
    });

    test('product created and linked to company', function () {
        $otherCompany = Company::factory()->create();

        $product = $this->action->handle($this->company, $this->baseData);

        expect($product->company_id)->toBe($this->company->id);
        
        $this->assertDatabaseMissing('products', [
            'company_id' => $otherCompany->id,
            'name' => 'Laptop Pro',
        ]);
    });

    test("create product, save image and update path in database", function () {
        $fakeImage = UploadedFile::fake()->image('product_image.jpg');
        
        $data = array_merge($this->baseData, [
            'featured_image' => $fakeImage,
        ]);

        $product = $this->action->handle($this->company, $data);

        $expectedPath = "{$this->company->id}/products/product_image.jpg";

        Storage::disk('public')->assertExists($expectedPath);

        $this->assertDatabaseHas('products', [
            'company_id' => $this->company->id,
            'sku' => 'SKU-LPRO-001',
            'featured_image' => $expectedPath,
        ]);
        
        expect($product->featured_image)->toBe($expectedPath);
    });
    
    // --- Test de la Transaction ---
    test("rollback transaction and product creation when storage failed", function () {
        // 1. Simuler une erreur : Mocker le Storage pour qu'il lance une exception
        Storage::shouldReceive('disk')
            ->with('public')
            ->once()
            ->andReturn(
                Mockery::mock(\Illuminate\Filesystem\FilesystemManager::class, function ($mock) {
                    // On mocke la méthode storeAs pour lancer une exception
                    $mock->shouldReceive('storeAs')
                        ->andThrow(new \Exception('Erreur simulée de stockage.'));
                })
            );

        // Préparation des données avec une image
        $fakeImage = UploadedFile::fake()->image('failing_image.jpg');
        $data = array_merge($this->baseData, [
            'featured_image' => $fakeImage,
        ]);

        // 2. Exécution dans un bloc 'expect' pour capter l'exception
        try {
            $this->action->handle($this->company, $data);
        } catch (\Exception $e) {
            // L'exception est levée, le test continue.
        }
        
        // 3. Assertion : Rien n'a été enregistré en BDD (Transaction rollback)
        $this->assertDatabaseMissing('products', [
            'sku' => 'SKU-LPRO-001',
            'company_id' => $this->company->id,
        ]);

        expect(Product::count())->toBe(0);
    });
});

