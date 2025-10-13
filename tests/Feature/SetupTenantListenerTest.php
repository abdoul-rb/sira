<?php

use App\Models\Company;
use App\Listeners\SetupTenantListener;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

beforeEach(function () {
    // Nettoyer le cache avant chaque test
    Cache::forget('tenant_companies_slugs');
    
    // Créer une instance du listener
    $this->listener = new SetupTenantListener(app());
});

it('returns early when no tenant parameter', function () {
    // Créer un mock de route sans paramètre tenant
    $route = Mockery::mock(Route::class);
    $route->shouldReceive('parameter')
          ->with('tenant')
          ->andReturn(null);
    
    $request = Request::create('/test');
    $event = new RouteMatched($request, $route);

    // Le listener ne doit pas lever d'exception
    expect(fn() => $this->listener->handle($event))->not->toThrow(Exception::class);
});

it('throws exception for invalid tenant', function () {
    // Créer un mock de route avec un tenant invalide
    $route = Mockery::mock(Route::class);
    $route->shouldReceive('parameter')
          ->with('tenant')
          ->andReturn('invalid-tenant');
    
    $request = Request::create('/test');
    $event = new RouteMatched($request, $route);

    // Le listener doit lever une exception
    expect(fn() => $this->listener->handle($event))
        ->toThrow(NotFoundHttpException::class);
});

it('configures tenant correctly', function () {
    // Créer une entreprise de test
    $company = Company::factory()->create([
        'name' => 'Test Company',
        'slug' => 'test-company',
        'active' => true,
    ]);

    // Créer un mock de route avec le tenant valide
    $route = Mockery::mock(Route::class);
    $route->shouldReceive('parameter')
          ->with('tenant')
          ->andReturn('test-company');
    
    $request = Request::create('/test');
    $event = new RouteMatched($request, $route);

    // Exécuter le listener
    $this->listener->handle($event);

    // Vérifier que le cache a été créé
    $cachedCompanies = Cache::get('tenant_companies_slugs');
    expect($cachedCompanies)->toBeArray();
    expect($cachedCompanies)->toContain('test-company');
});

it('caches companies correctly', function () {
    // Créer plusieurs entreprises
    Company::factory()->count(3)->create(['active' => true]);
    Company::factory()->create(['active' => false]); // Inactive

    // Créer un mock de route pour déclencher le cache
    $route = Mockery::mock(Route::class);
    $route->shouldReceive('parameter')
          ->with('tenant')
          ->andReturn('test-company');
    
    $request = Request::create('/test');
    $event = new RouteMatched($request, $route);

    // Vérifier que le cache est vide au début
    expect(Cache::get('tenant_companies_slugs'))->toBeNull();

    // Exécuter le listener (va échouer mais va créer le cache)
    try {
        $this->listener->handle($event);
    } catch (NotFoundHttpException $e) {
        // C'est normal, le tenant n'existe pas
    }

    // Vérifier que le cache a été créé
    $cachedCompanies = Cache::get('tenant_companies_slugs');
    expect($cachedCompanies)->toBeArray();
    expect($cachedCompanies)->toHaveCount(3); // Seulement les entreprises actives
});

it('ignores inactive companies', function () {
    // Créer une entreprise inactive
    Company::factory()->create([
        'slug' => 'inactive-company',
        'active' => false,
    ]);

    // Créer un mock de route avec le tenant inactif
    $route = Mockery::mock(Route::class);
    $route->shouldReceive('parameter')
          ->with('tenant')
          ->andReturn('inactive-company');
    
    $request = Request::create('/test');
    $event = new RouteMatched($request, $route);

    // Le listener doit lever une exception
    expect(fn() => $this->listener->handle($event))
        ->toThrow(NotFoundHttpException::class);
});

it('sets url defaults correctly', function () {
    // Créer une entreprise de test
    $company = Company::factory()->create([
        'slug' => 'test-company',
        'active' => true,
    ]);

    // Créer un mock de route avec le tenant valide
    $route = Mockery::mock(Route::class);
    $route->shouldReceive('parameter')
          ->with('tenant')
          ->andReturn('test-company');
    
    $request = Request::create('/test');
    $event = new RouteMatched($request, $route);

    // Exécuter le listener
    $this->listener->handle($event);

    // Vérifier que les defaults URL ont été configurés
    $urlGenerator = app('url');
    $defaults = $urlGenerator->getDefaultParameters();
    expect($defaults)->toHaveKey('tenant');
    expect($defaults['tenant'])->toBe('test-company');
}); 