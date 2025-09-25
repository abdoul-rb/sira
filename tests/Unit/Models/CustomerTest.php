<?php

declare(strict_types=1);

use App\Enums\CustomerType;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Quotation;

beforeEach(function () {
    $this->company = Company::factory()->create();
});

test('Customer: array expected columns', function () {
    $customer = Customer::factory()->create()->fresh();

    expect(array_keys($customer->toArray()))->toBe([
        'id',
        'uuid',
        'company_id',
        'firstname',
        'lastname',
        'email',
        'phone_number',
        'type',
        'address',
        'city',
        'zip_code',
        'country',
        'converted_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

describe('Customer Model', function () {
    test('peut créer un client avec les données de base', function () {
        $customer = Customer::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($customer)
            ->toBeInstanceOf(Customer::class)
            ->and($customer->company_id)->toBe($this->company->id)
            ->and($customer->firstname)->toBeString()
            ->and($customer->lastname)->toBeString()
            ->and($customer->email)->toBeString();
    });

    test('peut créer un prospect (lead)', function () {
        $customer = Customer::factory()->lead()->create([
            'company_id' => $this->company->id,
        ]);

        expect($customer->type)->toBe(CustomerType::LEAD)
            ->and($customer->converted_at)->toBeNull()
            ->and($customer->isLead())->toBeTrue()
            ->and($customer->isCustomer())->toBeFalse();
    });

    test('peut créer un client confirmé', function () {
        $customer = Customer::factory()->customer()->create([
            'company_id' => $this->company->id,
        ]);

        expect($customer->type)->toBe(CustomerType::CUSTOMER)
            ->and($customer->converted_at)->not->toBeNull()
            ->and($customer->isLead())->toBeFalse()
            ->and($customer->isCustomer())->toBeTrue();
    });

    test('peut convertir un prospect en client', function () {
        $customer = Customer::factory()->lead()->create([
            'company_id' => $this->company->id,
        ]);

        expect($customer->isLead())->toBeTrue();

        $customer->convertToCustomer();

        expect($customer->fresh()->type)->toBe(CustomerType::CUSTOMER)
            ->and($customer->fresh()->converted_at)->not->toBeNull()
            ->and($customer->fresh()->isCustomer())->toBeTrue();
    });

    test('génère le nom complet correctement', function () {
        $customer = Customer::factory()->create([
            'company_id' => $this->company->id,
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
        ]);

        expect($customer->fullname)->toBe('Jean Dupont');
    });

    test('peut avoir des devis associés', function () {
        $customer = Customer::factory()->create([
            'company_id' => $this->company->id,
        ]);

        Quotation::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $customer->id,
        ]);

        expect($customer->quotations)->toHaveCount(1)
            ->and($customer->quotations->first())->toBeInstanceOf(Quotation::class);
    });

    test('peut avoir des commandes associées', function () {
        $customer = Customer::factory()->create([
            'company_id' => $this->company->id,
        ]);

        Order::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $customer->id,
        ]);

        expect($customer->orders)->toHaveCount(1)
            ->and($customer->orders->first())->toBeInstanceOf(Order::class);
    });

    test('appartient à une entreprise', function () {
        $customer = Customer::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($customer->company)->toBeInstanceOf(Company::class)
            ->and($customer->company->id)->toBe($this->company->id);
    });

    describe('Scopes', function () {
        test('peut filtrer les prospects', function () {
            Customer::factory()->lead()->count(3)->create([
                'company_id' => $this->company->id,
            ]);
            
            Customer::factory()->customer()->count(2)->create([
                'company_id' => $this->company->id,
            ]);

            $leads = Customer::leads()->get();

            expect($leads)->toHaveCount(3)
                ->and($leads->every(fn ($customer) => $customer->isLead()))->toBeTrue();
        });

        test('peut filtrer les clients', function () {
            Customer::factory()->lead()->count(2)->create([
                'company_id' => $this->company->id,
            ]);
            Customer::factory()->customer()->count(4)->create([
                'company_id' => $this->company->id,
            ]);

            $customers = Customer::customers()->get();

            expect($customers)->toHaveCount(4)
                ->and($customers->every(fn ($customer) => $customer->isCustomer()))->toBeTrue();
        });
    });
});
