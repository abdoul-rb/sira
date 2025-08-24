<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\Public\Shop;
use App\Models\Company;
use App\Models\Product;
use App\Models\Shop as ShopModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PublicShopLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_shop_component_is_accessible()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = ShopModel::factory()->create([
            'company_id' => $company->id,
            'active' => true,
        ]);

        // Créer quelques produits
        Product::factory()->count(3)->create([
            'company_id' => $company->id,
        ]);

        // Tester le composant Livewire directement
        Livewire::test(Shop::class, ['tenant' => $company, 'shopSlug' => $shop->slug])
            ->assertSee($shop->name)
            ->assertSee($company->name);
    }

    public function test_public_shop_component_shows_products()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = ShopModel::factory()->create([
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

        // Tester le composant Livewire directement
        Livewire::test(Shop::class, ['tenant' => $company, 'shopSlug' => $shop->slug])
            ->assertSee('Produit Test 1')
            ->assertSee('Produit Test 2')
            ->assertSee('29,99 €')
            ->assertSee('49,99 €');
    }

    public function test_public_shop_component_returns_404_for_inactive_shop()
    {
        // Créer une entreprise avec une boutique inactive
        $company = Company::factory()->create();
        $shop = ShopModel::factory()->create([
            'company_id' => $company->id,
            'active' => false,
        ]);

        // Tester que le composant lance une exception pour une boutique inactive
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        
        Livewire::test(Shop::class, ['tenant' => $company, 'shopSlug' => $shop->slug]);
    }

    public function test_public_shop_component_search_functionality()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = ShopModel::factory()->create([
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

        // Tester la fonctionnalité de recherche
        Livewire::test(Shop::class, ['tenant' => $company, 'shopSlug' => $shop->slug])
            ->set('search', 'ordinateur')
            ->assertSee('Ordinateur portable')
            ->assertDontSee('Souris sans fil');
    }

    public function test_public_shop_component_shows_shop_information()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = ShopModel::factory()->create([
            'company_id' => $company->id,
            'active' => true,
            'description' => 'Description de test de la boutique',
        ]);

        // Tester le composant Livewire directement
        Livewire::test(Shop::class, ['tenant' => $company, 'shopSlug' => $shop->slug])
            ->assertSee('Description de test de la boutique')
            ->assertSee($shop->name);
    }

    public function test_public_shop_component_shows_all_products()
    {
        // Créer une entreprise avec une boutique
        $company = Company::factory()->create();
        $shop = ShopModel::factory()->create([
            'company_id' => $company->id,
            'active' => true,
        ]);

        // Créer plusieurs produits
        Product::factory()->count(15)->create([
            'company_id' => $company->id,
        ]);

        // Tester le composant Livewire directement
        Livewire::test(Shop::class, ['tenant' => $company, 'shopSlug' => $shop->slug])
            ->assertSee('15 produit(s) disponible(s)');
    }
}
