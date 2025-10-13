<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Purchase;
use App\Models\Supplier;
use Carbon\Carbon;

beforeEach(function () {
    $this->company = Company::factory()->create();
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
    test('peut créer un agent avec les données de base', function () {
        $purchase = Purchase::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($purchase)
            ->toBeInstanceOf(Purchase::class)
            ->and($purchase->company_id)->toBe($this->company->id)
            ->and($purchase->amount)->toBeFloat()
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

        expect($purchase->company)->toBeInstanceOf(Company::class)
            ->and($purchase->company->id)->toBe($this->company->id);
    });
});
