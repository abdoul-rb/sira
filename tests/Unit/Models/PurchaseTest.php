<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Purchase;
use App\Models\Supplier;
use Carbon\Carbon;

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create(['company_id' => $this->company->id]);
});

test('Purchase: array expected columns', function () {
    $purchase = Purchase::factory()->create()->fresh();

    expect(array_keys($purchase->toArray()))->toBe([
        'id',
        'company_id',
        'supplier_id',
        'amount',
        'details',
        'purchased_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

describe('Purchase Model', function () {
    test('peut créer un achat avec les données de base', function () {
        $purchase = Purchase::factory()->create([
            'company_id' => $this->company->id,
            'amount' => 100.50,
            'purchased_at' => now(),
            'details' => 'Test details',
        ]);

        expect($purchase)
            ->toBeInstanceOf(Purchase::class)
            ->and($purchase->company_id)->toBe($this->company->id)
            ->and($purchase->amount)->toBeString()->toBe('100.50') // decimal:2 cast returns string
            ->and($purchase->details)->toBeString()
            ->and($purchase->purchased_at)->toBeInstanceOf(Carbon::class);
    });

    test('appartient à une entreprise', function () {
        $purchase = Purchase::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($purchase->company)->toBeInstanceOf(Company::class)
            ->and($purchase->company->id)->toBe($this->company->id);
    });

    test('a un fournisseur associé', function () {
        $purchase = Purchase::factory()->create([
            'company_id' => $this->company->id,
            'supplier_id' => $this->supplier->id,
        ]);

        expect($purchase->supplier)->toBeInstanceOf(Supplier::class)
            ->and($purchase->supplier->id)->toBe($this->supplier->id);
    });

    test('Scope: forCompany', function () {
        Purchase::factory()->count(3)->create(['company_id' => $this->company->id]);
        $otherCompany = Company::factory()->create();
        Purchase::factory()->count(2)->create(['company_id' => $otherCompany->id]);

        $purchases = Purchase::forCompany($this->company->id)->get();

        expect($purchases)->toHaveCount(3)
            ->and($purchases->first()->company_id)->toBe($this->company->id);
    });
});
