<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Product;
use App\Actions\Product\EditAction as EditProductAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->company = Company::factory()->create(); 
    $this->action = app(EditProductAction::class);

    Storage::fake('public'); 
    
    $this->product = Product::factory()->for($this->company)->create([
        'name' => 'Produit Ancien',
        'price' => 10.00,
        'featured_image' => 'initial/path/old_image.jpg',
    ]);

    // Assurez-vous que l'ancienne image "existe" dans le Storage fake
    Storage::disk('public')->put('initial/path/old_image.jpg', 'fake content');

    // Les données de mise à jour (notez que 'stockQuantity' est le nom du champ dans votre Action)
    $this->updatedData = [
        'name' => 'Produit Mis à Jour',
        'description' => 'Description modifiée',
        'sku' => 'SKU-MODIF',
        'price' => 25.50,
        'stockQuantity' => 100,
        'featuredImage' => null,
    ];
});

describe('EditProductAction', function () {
    test("update product without change featured image", function () {
        $updatedProduct = $this->action->handle($this->product, $this->updatedData);

        expect($updatedProduct->name)->toBe('Produit Mis à Jour')
                ->and($updatedProduct->stock_quantity)->toBe(100);

        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'name' => 'Produit Mis à Jour',
            'price' => 25.50,
            'stock_quantity' => 100,
            'featured_image' => 'initial/path/old_image.jpg',
        ]);
        
        Storage::disk('public')->assertExists('initial/path/old_image.jpg');
    });

    test("remplace l'ancienne image par une nouvelle et supprime l'ancienne", function () {
        $newImage = UploadedFile::fake()->image('new_product_image.png');
        
        // Préparer les données avec la nouvelle image
        $dataWithNewImage = array_merge($this->updatedData, [
            'featuredImage' => $newImage,
        ]);
        
        // Chemin attendu pour la nouvelle image
        $expectedNewPath = "{$this->company->id}/products/new_product_image.png";

        // Exécuter l'Action
        $updatedProduct = $this->action->handle($this->product, $dataWithNewImage);

        // Vérifier la suppression de l'ancienne image
        Storage::disk('public')->assertMissing('initial/path/old_image.jpg');

        // Vérifier que la nouvelle image a été stockée
        Storage::disk('public')->assertExists($expectedNewPath);
        
        // Vérifier la BDD : le chemin est mis à jour
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'name' => 'Produit Mis à Jour',
            'featured_image' => $expectedNewPath,
        ]);
    });

    test("stocke la nouvelle image si aucune image n'existait", function () {
        // Créer un produit SANS image au départ
        $productWithoutImage = Product::factory()->for($this->company)->create([
            'featured_image' => null,
        ]);
        
        // Créer une nouvelle image fake
        $newImage = UploadedFile::fake()->image('first_image.jpg');
        
        $dataWithNewImage = array_merge($this->updatedData, [
            'featuredImage' => $newImage,
        ]);
        
        $expectedNewPath = "{$this->company->id}/products/first_image.jpg";

        // Exécuter l'Action sur le produit sans image
        $updatedProduct = $this->action->handle($productWithoutImage, $dataWithNewImage);

        // Vérifier que l'image a été stockée
        Storage::disk('public')->assertExists($expectedNewPath);
        
        $this->assertDatabaseHas('products', [
            'id' => $productWithoutImage->id,
            'featured_image' => $expectedNewPath,
        ]);
    });

    test("annule la mise à jour des données si le stockage de l'image échoue", function () {
        $originalName = $this->product->name; 
        $originalImage = $this->product->featured_image;

        // Simuler le fichier qui va déclencher le storeAs() mais avec échec
        $mockedFile = Mockery::mock(UploadedFile::class)
            ->shouldReceive('getError')->andReturn(0) 
            ->getMock();

        // Simuler que la méthode storeAs LANCE UNE EXCEPTION
        $mockedFile->shouldReceive('getClientOriginalName')->andReturn('failing_image.jpg');
        $mockedFile->shouldReceive('storeAs')
            ->once()
            ->andThrow(new \Exception('Erreur simulée de stockage.'));

        // Simuler la suppression
        Storage::shouldReceive('disk')
            ->with('public')
            ->times(2) // NOUS ATTENDONS 2 APPELS : 1 pour exists(), 1 pour delete()
            ->andReturnSelf(); 
        
        // Simuler les méthodes appelées sur l'objet Facade (via andReturnSelf)
        Storage::shouldReceive('exists')
            ->once()
            ->andReturn(true); 

        Storage::shouldReceive('delete')
            ->once(); 
        
        // Préparer les données avec le fichier mocké
        $dataWithNewImage = array_merge($this->updatedData, [
            'featuredImage' => $mockedFile, 
        ]);

        // Exécution dans un bloc 'try/catch'
        try {
            $this->action->handle($this->product, $dataWithNewImage);
        } catch (\Exception $e) {
            // L'exception est levée, le test continue pour vérifier le rollback.
        }
        
        // Assertion : Vérifier que les données n'ont PAS été mises à jour (rollback)
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'name' => $originalName, // Le nom est resté l'ancien
            'featured_image' => $originalImage, // Le chemin de l'image est resté l'ancien
        ]);
    });
});

