<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Order;
use Illuminate\Support\Carbon;
use App\Services\OrderNumberService;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    $this->service = new OrderNumberService();
    $this->company = Company::factory()->create();
});

describe("Command order number", function () {
    test('génère un numéro de commande avec le bon format', function () {
        $orderNumber = $this->service->generate($this->company);

        expect($orderNumber)->toMatch('/^\d{6}-\d{2}-\d{3}$/')
            ->and($orderNumber)->toHaveLength(13);
        
        // Vérifier que la date est celle d'aujourd'hui
        $today = now()->format('ymd');
        expect($orderNumber)->toStartWith($today);
        
        // Vérifier que l'incrément commence à 001
        expect($orderNumber)->toEndWith('-001');
    });

    test('incrémente correctement les numéros de commande du même jour', function () {
        $orderNumber1 = $this->service->generate($this->company);
        $orderNumber2 = $this->service->generate($this->company);
        
        // Extraire les incréments
        $parts1 = explode('-', $orderNumber1);
        $parts2 = explode('-', $orderNumber2);
        
        $increment1 = (int) $parts1[2];
        $increment2 = (int) $parts2[2];
        
        expect($increment2)->toBe($increment1 + 1);
    });

    test("récupère les statistiques d'une entreprise", function () {
        Order::factory()
            ->count(3)
            ->sequence(fn (Sequence $sequence) => ['company_id' => $this->company->id, 'order_number' => now()->format('ymd') . "-00{$sequence->index}-00001"]
        )->create();

        $stats = $this->service->getCompanyStats($this->company);
        
        expect($stats)->toHaveKeys(['today_orders', 'total_orders']);
        expect($stats['today_orders'])->toBe(3);
        expect($stats['total_orders'])->toBe(3);
    });

    test("les compteurs sont isolés entre les entreprises", function () {
        Carbon::setTestNow('2023-11-25');

        $companyA = Company::factory()->create(['id' => 10]);
        $companyB = Company::factory()->create(['id' => 20]);

        $orderA = $this->service->generate($companyA);
        expect($orderA)->toEndWith('-001');

        // L'entreprise B commande -> Doit être 001 aussi (pas 002 !)
        $orderB = $this->service->generate($companyB);
        expect($orderB)->toEndWith('-001');

        $orderA2 = $this->service->generate($companyA);
        expect($orderA2)->toEndWith('-002');
    });

    test("le compteur revient à 001 le lendemain", function () {
        // JOUR 1 : 25 Novembre
        Carbon::setTestNow('2023-11-25 23:59:00');
        
        $this->service->generate($this->company); // 001
        $lastOrderOfDay = $this->service->generate($this->company); // 002
        
        expect($lastOrderOfDay)->toEndWith('-002');

        // JOUR 2 : 26 Novembre (Le temps avance)
        Carbon::setTestNow('2023-11-26 08:00:00');
        
        $firstOrderNextDay = $this->service->generate($this->company);

        // Ça doit être 001 (et pas 003 !)
        expect($firstOrderNextDay)->toEndWith('-001');
        // Vérifier aussi que la date dans le numéro a changé
        expect($firstOrderNextDay)->toStartWith('231126');
    });

    test('gère correctement les commandes existantes dans la base de données', function () {
        Order::factory()
            ->count(5)
            ->sequence(fn (Sequence $sequence) => ['company_id' => $this->company->id, 'order_number' => now()->format('ymd') . "-00{$sequence->index}-00001"]
        )->create();
        
        $newOrderNumber = $this->service->generate($this->company);
        
        expect($newOrderNumber)->toEndWith('-006')
            ->and($newOrderNumber)->toContain('-01-');
    });
});

