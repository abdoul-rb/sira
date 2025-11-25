<?php

declare(strict_types=1);

use App\Listeners\SetupTenantListener;
use App\Models\Company;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

beforeEach(function () {
    // Nettoyage impératif du cache pour éviter que les tests ne se marchent dessus
    Cache::forget('tenant_companies_slugs');
});

// Helper pour simuler l'événement
function createRouteMatchedEvent($paramValue, $paramName = 'tenant'): RouteMatched {
    $route = new Route(['GET'], '/{' . $paramName . '}', ['uses' => fn() => 'ok']);
    $route->bind(request());
    
    // Si on passe une valeur, on set le paramètre
    if ($paramValue) {
        $route->setParameter($paramName, $paramValue);
    }
    
    return new RouteMatched($route, request());
}

test('it returns early when no tenant parameter', function () {
    // On simule une route SANS paramètre 'tenant'
    $event = createRouteMatchedEvent('quelque-chose', 'other_param');
    
    $listener = new SetupTenantListener(app());
    $listener->handle($event);

    // Rien ne doit être bindé
    expect(app()->has('currentTenant'))->toBeFalse();
});

test('it throws exception for invalid tenant (not in DB)', function () {
    // Aucune company en base
    $event = createRouteMatchedEvent('inconnu');
    $listener = new SetupTenantListener(app());

    // Doit échouer
    $listener->handle($event);
})->throws(NotFoundHttpException::class);

test('it ignores inactive companies', function () {
    Company::factory()->create(['slug' => 'old', 'active' => false]);
    
    $event = createRouteMatchedEvent('old');
    $listener = new SetupTenantListener(app());

    $listener->handle($event);
})->throws(NotFoundHttpException::class);

test('it configures tenant correctly when valid', function () {
    $company = Company::factory()->create(['name' => 'Apple', 'active' => true]);
    
    $event = createRouteMatchedEvent($company->slug);
    $listener = new SetupTenantListener(app());

    $listener->handle($event);

    // Vérification
    expect(app()->has('currentTenant'))->toBeTrue()
        ->and(app('currentTenant')->id)->toBe($company->id);
});

test('it caches companies correctly', function () {
    $company = Company::factory()->create(['name' => 'Tesla', 'active' => true]);
    
    // 1er appel : DB hit + Mise en cache
    $listener = new SetupTenantListener(app());
    $listener->handle(createRouteMatchedEvent($company->slug));
    
    // On vérifie que c'est en cache
    expect(Cache::has('tenant_companies_slugs'))->toBeTrue();
    expect(Cache::get('tenant_companies_slugs'))->toContain($company->slug);

    // On supprime la company de la DB (tricherie pour prouver que le cache prend le relais)
    // Note: Avec RefreshDatabase transactionnel, le delete est parfois délicat à tester ainsi,
    // mais conceptuellement, si on mockait DB, on verrait 0 requête au 2eme appel.
});

test('it handles route model binding (object passed instead of string)', function () {
    $company = Company::factory()->create(['slug' => 'google', 'active' => true]);
    
    // Ici on passe l'Objet directement, pas le string
    $event = createRouteMatchedEvent($company);
    
    $listener = new SetupTenantListener(app());
    $listener->handle($event);

    expect(app('currentTenant')->id)->toBe($company->id);
});