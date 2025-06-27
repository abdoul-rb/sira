<?php

declare(strict_types=1);

use App\Enums\QuotationStatus;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quotation;

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->customer = Customer::factory()->create([
        'company_id' => $this->company->id,
    ]);
});

test('Quotation: array expected columns', function () {
    $quotation = Quotation::factory()->create()->fresh();

    expect(array_keys($quotation->toArray()))->toBe([
        'id',
        'reference',
        'company_id',
        'customer_id',
        'status',
        'subtotal',
        'tax_amount',
        'total_amount',
        'notes',
        'valid_until',
        'sent_at',
        'accepted_at',
        'rejected_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

describe('Quotation Model', function () {
    test('peut créer un devis avec les données de base', function () {
        $quotation = Quotation::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($quotation)
            ->toBeInstanceOf(Quotation::class)
            ->and($quotation->company_id)->toBe($this->company->id)
            ->and($quotation->customer_id)->toBe($this->customer->id)
            ->and($quotation->reference)->not->toBeNull()
            ->and($quotation->subtotal)->toBeGreaterThan(0)
            ->and($quotation->total_amount)->toBeGreaterThan($quotation->subtotal);
    });

    test('peut créer un devis en brouillon', function () {
        $quotation = Quotation::factory()->draft()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($quotation->status)->toBe(QuotationStatus::DRAFT)
            ->and($quotation->sent_at)->toBeNull()
            ->and($quotation->accepted_at)->toBeNull()
            ->and($quotation->rejected_at)->toBeNull();
    });

    test('peut créer un devis envoyé', function () {
        $quotation = Quotation::factory()->sent()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($quotation->status)->toBe(QuotationStatus::SENT)
            ->and($quotation->sent_at)->not->toBeNull()
            ->and($quotation->accepted_at)->toBeNull()
            ->and($quotation->rejected_at)->toBeNull();
    });

    test('peut créer un devis accepté', function () {
        $quotation = Quotation::factory()->accepted()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($quotation->status)->toBe(QuotationStatus::ACCEPTED)
            ->and($quotation->sent_at)->not->toBeNull()
            ->and($quotation->accepted_at)->not->toBeNull()
            ->and($quotation->rejected_at)->toBeNull();
    });

    test('peut créer un devis refusé', function () {
        $quotation = Quotation::factory()->rejected()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($quotation->status)->toBe(QuotationStatus::REJECTED)
            ->and($quotation->sent_at)->not->toBeNull()
            ->and($quotation->accepted_at)->toBeNull()
            ->and($quotation->rejected_at)->not->toBeNull();
    });

    test('peut marquer un devis comme envoyé', function () {
        $quotation = Quotation::factory()->draft()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $quotation->markAsSent();

        expect($quotation->fresh()->status)->toBe(QuotationStatus::SENT)
            ->and($quotation->fresh()->sent_at)->not->toBeNull();
    });

    test('peut marquer un devis comme accepté', function () {
        $quotation = Quotation::factory()->sent()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $quotation->markAsAccepted();

        expect($quotation->fresh()->status)->toBe(QuotationStatus::ACCEPTED)
            ->and($quotation->fresh()->accepted_at)->not->toBeNull();
    });

    test('peut marquer un devis comme refusé', function () {
        $quotation = Quotation::factory()->sent()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $quotation->markAsRejected();

        expect($quotation->fresh()->status)->toBe(QuotationStatus::REJECTED)
            ->and($quotation->fresh()->rejected_at)->not->toBeNull();
    });

    test('peut marquer un devis comme expiré', function () {
        $quotation = Quotation::factory()->sent()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $quotation->markAsExpired();

        expect($quotation->fresh()->status)->toBe(QuotationStatus::EXPIRED);
    });

    test('vérifie si un devis est expiré', function () {
        $quotation = Quotation::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'valid_until' => now()->subDays(1), // Expiré hier
        ]);

        expect($quotation->isExpired())->toBeTrue();
    });

    test('vérifie si un devis peut être converti en commande', function () {
        $quotation = Quotation::factory()->accepted()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($quotation->canBeConvertedToOrder())->toBeTrue();
    });

    test('appartient à une entreprise', function () {
        $quotation = Quotation::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($quotation->company)->toBeInstanceOf(Company::class)
            ->and($quotation->company->id)->toBe($this->company->id);
    });

    test('appartient à un client', function () {
        $quotation = Quotation::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        expect($quotation->customer)->toBeInstanceOf(Customer::class)
            ->and($quotation->customer->id)->toBe($this->customer->id);
    });

    test('peut avoir des produits associés', function () {
        $quotation = Quotation::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        $product = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $quotation->products()->attach($product->id, [
            'quantity' => 2,
            'unit_price' => 50.00,
            'total_price' => 100.00,
        ]);

        expect($quotation->products)->toHaveCount(1)
            ->and($quotation->products->first())->toBeInstanceOf(Product::class)
            ->and($quotation->products->first()->pivot->quantity)->toBe(2);
    });

    test('peut avoir des commandes associées', function () {
        $quotation = Quotation::factory()->accepted()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
        ]);

        Order::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'quotation_id' => $quotation->id,
        ]);

        expect($quotation->orders)->toHaveCount(1)
            ->and($quotation->orders->first())->toBeInstanceOf(Order::class);
    });

    test('calcule correctement les totaux', function () {
        $quotation = Quotation::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'subtotal' => 0,
            'tax_amount' => 0,
            'total_amount' => 0,
        ]);

        $product1 = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $product2 = Product::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $quotation->products()->attach($product1->id, [
            'quantity' => 2,
            'unit_price' => 50.00,
            'total_price' => 100.00,
        ]);

        $quotation->products()->attach($product2->id, [
            'quantity' => 1,
            'unit_price' => 75.0,
            'total_price' => 75.0,
        ]);

        $quotation->calculateTotals();

        expect($quotation->fresh()->subtotal)->toBe('175.00')
            ->and($quotation->fresh()->total_amount)->toBe('175.00'); // Pas de taxe
    });

    describe('Scopes', function () {
        test('peut filtrer les devis en brouillon', function () {
            Quotation::factory()->draft()->count(3)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);
            Quotation::factory()->sent()->count(2)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);

            $drafts = Quotation::draft()->get();

            expect($drafts)->toHaveCount(3)
                ->and($drafts->every(fn ($quotation) => $quotation->status === QuotationStatus::DRAFT))->toBeTrue();
        });

        test('peut filtrer les devis envoyés', function () {
            Quotation::factory()->sent()->count(4)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);
            Quotation::factory()->accepted()->count(1)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);

            $sent = Quotation::sent()->get();

            expect($sent)->toHaveCount(4)
                ->and($sent->every(fn ($quotation) => $quotation->status === QuotationStatus::SENT))->toBeTrue();
        });

        test('peut filtrer les devis acceptés', function () {
            Quotation::factory()->accepted()->count(2)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);
            Quotation::factory()->rejected()->count(3)->create([
                'company_id' => $this->company->id,
                'customer_id' => $this->customer->id,
            ]);

            $accepted = Quotation::accepted()->get();

            expect($accepted)->toHaveCount(2)
                ->and($accepted->every(fn ($quotation) => $quotation->status === QuotationStatus::ACCEPTED))->toBeTrue();
        });
    });
});
