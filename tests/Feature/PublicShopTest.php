<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_shop_page_is_accessible_without_authentication()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = Shop::factory()->create([
            'company_id' => $company->id,
            'active' => true,
        ]);

        // Créer quelques produits
        Product::factory()->count(3)->create([
            'company_id' => $company->id,
        ]);

        // Accéder à la page publique de la boutique
        $response = $this->get("http://{$company->slug}." . config('app.url') . "/shop/{$shop->slug}");

        $response->assertStatus(200);
        $response->assertSee($shop->name);
        $response->assertSee($company->name);
    }

    public function test_public_shop_page_shows_products()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = Shop::factory()->create([
            'company_id' => $company->id,
            'active' => true,
        ]);

        // Créer des produits avec des noms spécifiques
        $product1 = Product::factory()->create([
            'company_id' => $company->id,
            'name' => 'Produit Test 1',
            'price' => 29.99,
        ]);

        $product2 = Product::factory()->create([
            'company_id' => $company->id,
            'name' => 'Produit Test 2',
            'price' => 49.99,
        ]);

        // Accéder à la page publique de la boutique
        $response = $this->get("http://{$company->slug}." . config('app.url') . "/shop/{$shop->slug}");

        $response->assertStatus(200);
        $response->assertSee('Produit Test 1');
        $response->assertSee('Produit Test 2');
        $response->assertSee('29,99 €');
        $response->assertSee('49,99 €');
    }

    public function test_public_shop_page_returns_404_for_inactive_shop()
    {
        // Créer une entreprise avec une boutique inactive
        $company = Company::factory()->create();
        $shop = Shop::factory()->create([
            'company_id' => $company->id,
            'active' => false,
        ]);

        // Tenter d'accéder à la page publique de la boutique inactive
        $response = $this->get("http://{$company->slug}." . config('app.url') . "/shop/{$shop->slug}");

        $response->assertStatus(404);
    }

    public function test_public_shop_page_returns_404_for_nonexistent_shop()
    {
        // Créer une entreprise pour le test
        $company = Company::factory()->create();
        
        // Tenter d'accéder à une boutique qui n'existe pas
        $response = $this->get("http://{$company->slug}." . config('app.url') . "/shop/boutique-inexistante");

        $response->assertStatus(404);
    }

    public function test_public_shop_page_search_functionality()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = Shop::factory()->create([
            'company_id' => $company->id,
            'active' => true,
        ]);

        // Créer des produits avec des noms spécifiques
        Product::factory()->create([
            'company_id' => $company->id,
            'name' => 'Ordinateur portable',
            'description' => 'Ordinateur portable performant',
        ]);

        Product::factory()->create([
            'company_id' => $company->id,
            'name' => 'Souris sans fil',
            'description' => 'Souris ergonomique',
        ]);

        // Rechercher par nom de produit
        $response = $this->get("http://{$company->slug}." . config('app.url') . "/shop/{$shop->slug}?search=ordinateur");

        $response->assertStatus(200);
        $response->assertSee('Ordinateur portable');
        $response->assertDontSee('Souris sans fil');
    }

    public function test_public_shop_page_shows_shop_information()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = Shop::factory()->create([
            'company_id' => $company->id,
            'active' => true,
            'description' => 'Description de test de la boutique',
        ]);

        // Accéder à la page publique de la boutique
        $response = $this->get("http://{$company->slug}." . config('app.url') . "/shop/{$shop->slug}");

        $response->assertStatus(200);
        $response->assertSee('Description de test de la boutique');
        $response->assertSee($shop->name);
    }

    public function test_public_shop_page_shows_all_products()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = Shop::factory()->create([
            'company_id' => $company->id,
            'active' => true,
        ]);

        // Créer plusieurs produits
        Product::factory()->count(15)->create([
            'company_id' => $company->id,
        ]);

        // Accéder à la page publique de la boutique
        $response = $this->get("http://{$company->slug}." . config('app.url') . "/shop/{$shop->slug}");

        $response->assertStatus(200);
        $response->assertSee('15 produit(s) disponible(s)');
        
        // Vérifier que tous les produits sont affichés (pas de pagination)
        $response->assertDontSee('Suivant');
    }
}
