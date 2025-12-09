<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\Member;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;

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
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at'
    ]);
});

test('Module: create a module', function () {
    $company = Company::factory()->create(['active' => true])->fresh();

    expect($company)->toBeInstanceOf(Company::class)
        ->and($company->slug)->not()->toBeNull()
        ->and($company->uuid)->not()->toBeNull()
        ->and($company->active)->toBeTrue();
});

describe("Boot", function () {
    test('La compagnie a un slug et un uuid', function () {
        $company = Company::factory()->create(['active' => true])->fresh();

        expect($company->slug)->not()->toBeNull()
            ->and($company->uuid)->not()->toBeNull();
            // ->and($company->uuid)->toBeInstanceOf(Ramsey\Uuid\Lazy\LazyUuidFromString::class);
    });
});

describe("Scopes", function () {
    test('get active companies', function () {
        $company = Company::factory()->create(['active' => true])->fresh();
        Company::factory()->create(['active' => false])->fresh();

        $activeCompanies = Company::active()->get();

        expect($activeCompanies->count())->toBe(1);
    });
});

describe("Relationships", function () {
    test('a company has many customers', function () {
        $company = Company::factory()->create();
        Customer::factory()->count(3)->create(['company_id' => $company->id]);

        expect($company->customers)
            ->toHaveCount(3)
            ->first()->toBeInstanceOf(Customer::class);
    });

    test('a company has many products', function () {
        $company = Company::factory()->create();
        Product::factory()->count(2)->create(['company_id' => $company->id]);

        expect($company->products)->toHaveCount(2);
    });

    test('a company has many orders', function () {
        $company = Company::factory()->create();
        Order::factory()->count(2)->create(['company_id' => $company->id]);

        expect($company->orders)->toHaveCount(2);
    });

    test('a company has many members', function () {
        $company = Company::factory()->create();
        Member::factory()->count(2)->create(['company_id' => $company->id]);

        expect($company->members)->toHaveCount(2);
    });

    test('a company has many warehouses', function () {
        $company = Company::factory()->create();
        Warehouse::factory()->count(2)->create(['company_id' => $company->id]);

        expect($company->warehouses)->toHaveCount(2);
    });

    test('a company has many suppliers', function () {
        $company = Company::factory()->create();
        Supplier::factory()->count(2)->create(['company_id' => $company->id]);

        expect($company->suppliers)->toHaveCount(2);
    });

    test('a company has many deposits', function () {
        $company = Company::factory()->create();
        Deposit::factory()->count(2)->create(['company_id' => $company->id]);

        expect($company->deposits)->toHaveCount(2);
    });

    test('a company has many purchases', function () {
        $company = Company::factory()->create();
        Purchase::factory()->count(2)->create(['company_id' => $company->id]);

        expect($company->purchases)->toHaveCount(2);
    });
});

// getInitialsAttribute
describe("Attributes and methods", function () {
    test('get initials', function () {
        $company = Company::factory()->create(['name' => 'Acme']);

        expect($company->initials)->toBe('AC');
    });

    test('it returns the default warehouse only', function () {
        $company = Company::factory()->create();

        Warehouse::factory()->create([
            'company_id' => $company->id,
            'default' => false
        ]);

        $expectedWarehouse = Warehouse::factory()->create([
            'company_id' => $company->id,
            'default' => true
        ]);

        $result = $company->defaultWarehouse();

        expect($result)
            ->not->toBeNull()
            ->and($result->id)->toBe($expectedWarehouse->id);
    });

    test('it returns null if no default warehouse exists', function () {
        $company = Company::factory()->create();

        Warehouse::factory()->create([
            'company_id' => $company->id,
            'default' => false
        ]);

        expect($company->defaultWarehouse())->toBeNull();
    });

    test('it retrieves the main supplier correctly', function () {
        $company = Company::factory()->create();

        Supplier::factory()->create([
            'company_id' => $company->id,
            'main' => false
        ]);

        $mainSupplier = Supplier::factory()->create([
            'company_id' => $company->id,
            'main' => true
        ]);

        $result = $company->mainSupplier();

        expect($result)
            ->not->toBeNull()
            ->toBeInstanceOf(Supplier::class)
            ->and($result->id)->toBe($mainSupplier->id);
    });

    test('it does not return the main supplier of another company', function () {
        $myCompany = Company::factory()->create();
        $otherCompany = Company::factory()->create();

        Supplier::factory()->create([
            'company_id' => $otherCompany->id,
            'main' => true
        ]);

        expect($myCompany->mainSupplier())->toBeNull();
    });
});