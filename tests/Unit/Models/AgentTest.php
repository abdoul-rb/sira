<?php

declare(strict_types=1);

use App\Enums\CustomerType;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Quotation;
use App\Models\Agent;

beforeEach(function () {
    $this->company = Company::factory()->create();
});

test('Agent: array expected columns', function () {
    $agent = Agent::factory()->create()->fresh();

    expect(array_keys($agent->toArray()))->toBe([
        'id',
        'uuid',
        'company_id',
        'firstname',
        'lastname',
        'phone_number',
        'localization',
        'active',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

describe('Agent Model', function () {
    test('peut créer un agent avec les données de base', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($agent)
            ->toBeInstanceOf(Agent::class)
            ->and($agent->company_id)->toBe($this->company->id)
            ->and($agent->firstname)->toBeString()
            ->and($agent->lastname)->toBeString()
            ->and($agent->uuid)->toBeInstanceOf(Ramsey\Uuid\Lazy\LazyUuidFromString::class);
    });

    test('génère automatiquement un UUID lors de la création', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($agent->uuid)->not()->toBeNull()
            ->and($agent->uuid)->toBeInstanceOf(Ramsey\Uuid\Lazy\LazyUuidFromString::class);
    });

    test('génère le nom complet correctement', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
        ]);

        expect($agent->fullname)->toBe('Jean Dupont');
    });

    test('génère les initiales correctement', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
        ]);

        expect($agent->initials)->toBe('JD');
    });

    test('gère les espaces dans le nom complet', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
            'firstname' => 'Jean-Claude',
            'lastname' => 'Van Damme',
        ]);

        expect($agent->fullname)->toBe('Jean-Claude Van Damme');
    });

    test('peut être inactif', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
            'active' => false,
        ]);

        expect($agent->active)->toBeFalse();
    });

    test('est actif par défaut', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($agent->active)->toBeTrue();
    });

    test('peut avoir un numéro de téléphone', function () {
        $phoneNumber = '+33123456789';
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
            'phone_number' => $phoneNumber,
        ]);

        expect($agent->phone_number)->toBe($phoneNumber);
    });

    test('peut ne pas avoir de numéro de téléphone', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
            'phone_number' => null,
        ]);

        expect($agent->phone_number)->toBeNull();
    });

    test('peut avoir une localization', function () {
        $localization = '123 Rue de la Paix, 75001 Paris';
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
            'localization' => $localization,
        ]);

        expect($agent->localization)->toBe($localization);
    });

    test('peut ne pas avoir de localization', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
            'localization' => null,
        ]);

        expect($agent->localization)->toBeNull();
    });

    test('appartient à une entreprise', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($agent->company)->toBeInstanceOf(\App\Models\Company::class)
            ->and($agent->company->id)->toBe($this->company->id);
    });

    test('utilise le soft delete', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $agentId = $agent->id;
        $agent->delete();

        expect(Agent::find($agentId))->toBeNull()
            ->and(Agent::withTrashed()->find($agentId))->not->toBeNull();
    });

    test('peut être restauré après suppression', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $agent->delete();
        expect(Agent::find($agent->id))->toBeNull();

        $agent->restore();
        expect(Agent::find($agent->id))->not->toBeNull();
    });

    test('utilise UUID comme clé de route', function () {
        $agent = Agent::factory()->create([
            'company_id' => $this->company->id,
        ]);

        expect($agent->getRouteKeyName())->toBe('uuid');
    });

    describe('Scopes', function () {
        test('peut filtrer les agents actifs', function () {
            Agent::factory()->count(3)->create([
                'company_id' => $this->company->id,
                'active' => true,
            ]);
            
            Agent::factory()->count(2)->create([
                'company_id' => $this->company->id,
                'active' => false,
            ]);

            $activeAgents = Agent::where('active', true)->get();

            expect($activeAgents)->toHaveCount(3)
                ->and($activeAgents->every(fn ($agent) => $agent->active))->toBeTrue();
        });

        test('peut filtrer les agents inactifs', function () {
            Agent::factory()->count(2)->create([
                'company_id' => $this->company->id,
                'active' => true,
            ]);
            
            Agent::factory()->count(4)->create([
                'company_id' => $this->company->id,
                'active' => false,
            ]);

            $inactiveAgents = Agent::where('active', false)->get();

            expect($inactiveAgents)->toHaveCount(4)
                ->and($inactiveAgents->every(fn ($agent) => !$agent->active))->toBeTrue();
        });
    });
});
