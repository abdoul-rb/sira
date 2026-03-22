<?php

declare(strict_types=1);

use App\Actions\Shop\CreateShopAction;
use App\Models\Company;
use App\Models\Shop;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a shop for a company', function () {
    $company = Company::create(['name' => 'Test', 'country' => 'Test', 'active' => true]);
    $action = new CreateShopAction();
    $data = [
        'shopName' => 'Test Shop',
        'shopDescription' => 'Test Description'
    ];

    $shop = $action->handle($company, $data);

    expect($shop)->toBeInstanceOf(Shop::class)
        ->and($shop->name)->toBe('Test Shop')
        ->and($shop->description)->toBe('Test Description')
        ->and($shop->company_id)->toBe($company->id)
        ->and(boolval($shop->active))->toBeTrue();

    $this->assertDatabaseHas('shops', ['name' => 'Test Shop']);
});
