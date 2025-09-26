<?php

declare(strict_types=1);

use App\Models\Company;

test('Category: array expected columns', function () {
    $company = Company::factory()->create()->fresh();

    expect(array_keys($company->toArray()))->toBe([
        'id',
        'uuid',
        'slug',
        'name',
        'email',
        'phone_number',
        'website',
        'active',
        'logo_path',
        'address',
        'city',
        'country',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

test('Module: create a module', function () {
    $company = Company::factory()->create(['active' => true])->fresh();

    expect($company)->toBeInstanceOf(Company::class)
        ->and($company->slug)->not()->toBeNull()
        ->and($company->uuid)->not()->toBeNull()
        ->and($company->active)->toBeTrue();
});