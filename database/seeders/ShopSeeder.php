<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        // Créer une boutique pour la première entreprise existante
        $company = Company::first();

        if ($company && ! $company->shop) {
            Shop::create([
                'company_id' => $company->id,
                'name' => 'Boutique ' . $company->name,
                'slug' => 'boutique-' . $company->slug,
                'description' => 'Découvrez nos produits de qualité dans notre boutique en ligne.',
                'facebook_url' => 'https://facebook.com/' . $company->slug,
                'instagram_url' => 'https://instagram.com/' . $company->slug,
                'active' => true,
            ]);
        }
    }
}
