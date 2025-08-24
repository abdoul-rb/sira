<?php

declare(strict_types=1);

use App\Models\Shop;
use App\Models\Company;

test('Shop: array expected columns', function () {
    $shop = Shop::factory()->create()->fresh();

    expect(array_keys($shop->toArray()))->toBe([
        'id',
        'company_id',
        'name',
        'slug',
        'logo_path',
        'description',
        'facebook_url',
        'instagram_url',
        'active',
        'created_at',
        'updated_at',
    ]);
});

test('Shop: create a shop', function () {
    $shop = Shop::factory()->create()->fresh();

    expect($shop)->toBeInstanceOf(Shop::class)
        ->and($shop->slug)->not()->toBeNull()
        ->and($shop->active)->toBeTrue();
});

test('Shop: have one company', function () {
    $shop = Shop::factory()->create()->fresh();

    expect($shop->company)->toBeInstanceOf(Company::class);
});