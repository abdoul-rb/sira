<?php

declare(strict_types=1);

use App\Actions\Shop\UpdateOrCreateShopAction;
use App\Models\Company;
use App\Models\Shop;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('UpdateOrCreateShopAction → crée une nouvelle boutique sans logo', function () {
    $company = Company::factory()->create();
    $shop = new Shop;

    $data = [
        'name' => 'Ma Boutique Test',
        'description' => 'Description de test',
        'facebookUrl' => 'https://facebook.com/test',
        'instagramUrl' => 'https://instagram.com/test',
        'active' => true,
    ];

    $action = new UpdateOrCreateShopAction;
    $result = $action->handle($company, $shop, $data);

    expect($result)->toBeInstanceOf(Shop::class)
        ->and($result->exists)->toBeTrue()
        ->and($result->name)->toBe('Ma Boutique Test')
        ->and($result->company_id)->toBe($company->id)
        ->and($result->active)->toBeTrue();
});

test('UpdateOrCreateShopAction → crée une nouvelle boutique avec logo', function () {
    $company = Company::factory()->create();
    $shop = new Shop;

    $logo = UploadedFile::fake()->image('logo.jpg', 200, 200);

    $data = [
        'name' => 'Boutique avec Logo',
        'description' => 'Test avec upload',
        'facebookUrl' => null,
        'instagramUrl' => null,
        'active' => true,
        'newLogo' => $logo,
    ];

    $action = new UpdateOrCreateShopAction;
    $result = $action->handle($company, $shop, $data);

    expect($result)->toBeInstanceOf(Shop::class)
        ->and($result->exists)->toBeTrue()
        ->and($result->logo_path)->not->toBeNull()
        ->and($result->logo_path)->toContain("{$company->id}/shop/");

    Storage::disk('public')->assertExists($result->logo_path);
});

test('UpdateOrCreateShopAction → met à jour une boutique existante', function () {
    $company = Company::factory()->create();
    $shop = Shop::factory()->create([
        'company_id' => $company->id,
        'name' => 'Ancien Nom',
        'description' => 'Ancienne description',
    ]);

    $data = [
        'name' => 'Nouveau Nom',
        'description' => 'Nouvelle description',
        'facebookUrl' => 'https://facebook.com/updated',
        'instagramUrl' => 'https://instagram.com/updated',
        'active' => false,
    ];

    $action = new UpdateOrCreateShopAction;
    $result = $action->handle($company, $shop, $data);

    expect($result->id)->toBe($shop->id)
        ->and($result->name)->toBe('Nouveau Nom')
        ->and($result->description)->toBe('Nouvelle description')
        ->and($result->active)->toBeFalse();
});

test('UpdateOrCreateShopAction → remplace le logo lors de la mise à jour', function () {
    $company = Company::factory()->create();
    
    // Créer une boutique avec un logo existant
    $oldLogo = UploadedFile::fake()->image('old-logo.jpg');
    $oldLogoPath = "{$company->id}/shop/old-logo.jpg";
    Storage::disk('public')->putFileAs("{$company->id}/shop", $oldLogo, 'old-logo.jpg');

    $shop = Shop::factory()->create([
        'company_id' => $company->id,
        'logo_path' => $oldLogoPath,
    ]);

    // Mettre à jour avec un nouveau logo
    $newLogo = UploadedFile::fake()->image('new-logo.jpg');

    $data = [
        'name' => $shop->name,
        'description' => $shop->description,
        'facebookUrl' => $shop->facebook_url,
        'instagramUrl' => $shop->instagram_url,
        'active' => $shop->active,
        'newLogo' => $newLogo,
    ];

    $action = new UpdateOrCreateShopAction;
    $result = $action->handle($company, $shop, $data);

    expect($result->logo_path)->toContain('new-logo.jpg')
        ->and($result->logo_path)->not->toBe($oldLogoPath);

    // Vérifier que l'ancien logo a été supprimé
    Storage::disk('public')->assertMissing($oldLogoPath);
    // Vérifier que le nouveau logo existe
    Storage::disk('public')->assertExists($result->logo_path);
});

test('UpdateOrCreateShopAction → conserve le logo existant si aucun nouveau logo fourni', function () {
    $company = Company::factory()->create();

    $oldLogo = UploadedFile::fake()->image('existing-logo.jpg');
    $oldLogoPath = "{$company->id}/shop/existing-logo.jpg";
    Storage::disk('public')->putFileAs("{$company->id}/shop", $oldLogo, 'existing-logo.jpg');

    $shop = Shop::factory()->create([
        'company_id' => $company->id,
        'logo_path' => $oldLogoPath,
    ]);

    $data = [
        'name' => 'Nom Mis à Jour',
        'description' => $shop->description,
        'facebookUrl' => $shop->facebook_url,
        'instagramUrl' => $shop->instagram_url,
        'active' => $shop->active,
    ];

    $action = new UpdateOrCreateShopAction;
    $result = $action->handle($company, $shop, $data);

    expect($result->logo_path)->toBe($oldLogoPath);
    Storage::disk('public')->assertExists($oldLogoPath);
});
