<?php

declare(strict_types=1);

use App\Enums\CustomerType;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Quotation;
use App\Models\Supplier;
use App\Models\Agent;

beforeEach(function () {
    $this->company = Company::factory()->create();
});

test('Supplier: array expected columns', function () {
    $supplier = Supplier::factory()->create()->fresh();

    expect(array_keys($supplier->toArray()))->toBe([
        'id',
        'company_id',
        'name',
        'main',
        'email',
        'phone_number',
        'created_at',
        'updated_at',
    ]);
});

describe('Supplier Model', function () {
    test('peut créer un agent avec les données de base', function () {
        $supplier = Supplier::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($supplier)
            ->toBeInstanceOf(Supplier::class)
            ->and($supplier->company_id)->toBe($this->company->id)
            ->and($supplier->name)->toBeString()
            ->and($supplier->main)->toBeBool()
            ->and($supplier->email)->toBeString()
            ->and($supplier->phone_number)->toBeString();
    });


    test('peut ne pas être le fournisseur principal', function () {
        $supplier = Supplier::factory()->create([
            'company_id' => $this->company->id,
            'main' => false,
        ]);

        expect($supplier->main)->toBeFalse();
    });

    test('est le fournisseur principal par défaut', function () {
        $supplier = Supplier::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($supplier->main)->toBeTrue();
    });

    test('appartient à une entreprise', function () {
        $supplier = Supplier::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($supplier->company)->toBeInstanceOf(Company::class)
            ->and($supplier->company->id)->toBe($this->company->id);
    });

    describe('Scopes', function () {
        test('peut filtrer les fournisseurs principaux', function () {
            Supplier::factory()->count(3)->create([
                'company_id' => $this->company->id,
                'main' => true,
            ]);
            
            Supplier::factory()->count(2)->create([
                'company_id' => $this->company->id,
                'main' => false,
            ]);

            $activeSuppliers = Supplier::where('main', true)->get();

            expect($activeSuppliers)->toHaveCount(3)
                ->and($activeSuppliers->every(fn ($supplier) => $supplier->main))->toBeTrue();
        });
    });
});
