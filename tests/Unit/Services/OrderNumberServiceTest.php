<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Order;
use App\Services\OrderNumberService;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    $this->service = new OrderNumberService();
    $this->company = Company::factory()->create();
});

/* test("génère un hash court unique", function () {
    $hash = $this->service->generateShortHash($this->company);

    expect($hash)->toBeString();
    expect($hash)->toHaveLength(6);
}); */

/* test("compteur global par entreprise", function () {
    $globalIncrement = $this->service->getGlobalIncrement($this->company);

    expect($globalIncrement)->toBeString();
    expect($globalIncrement)->toHaveLength(5);
}); */

test('génère un numéro de commande avec le bon format', function () {
    $orderNumber = $this->service->generate($this->company);

    expect($orderNumber)->toMatch('/^\d{6}-\d{3}-\d{5}$/')
        ->and($orderNumber)->toHaveLength(16);
    
    // Vérifier que la date est celle d'aujourd'hui
    $today = now()->format('ymd');
    expect($orderNumber)->toStartWith($today);
    
    // Vérifier que l'incrément commence à 001
    expect($orderNumber)->toContain('-001-');
});

test('incrémente correctement les numéros de commande du même jour', function () {
    $orderNumber1 = $this->service->generate($this->company);
    $orderNumber2 = $this->service->generate($this->company);
    
    // Extraire les incréments
    $parts1 = explode('-', $orderNumber1);
    $parts2 = explode('-', $orderNumber2);
    
    $increment1 = (int) $parts1[1];
    $increment2 = (int) $parts2[1];
    
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

test('gère correctement les commandes existantes dans la base de données', function () {
    Order::factory()
        ->count(5)
        ->sequence(fn (Sequence $sequence) => ['company_id' => $this->company->id, 'order_number' => now()->format('ymd') . "-00{$sequence->index}-00001"]
    )->create();
    
    $newOrderNumber = $this->service->generate($this->company);
    
    expect($newOrderNumber)->toContain('-006-');
});
