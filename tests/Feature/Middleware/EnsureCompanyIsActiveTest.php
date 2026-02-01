<?php

declare(strict_types=1);

use App\Http\Middleware\EnsureCompanyIsActive;
use App\Models\Company;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

describe('EnsureCompanyIsActive Middleware', function () {
    test('laisse passer si aucun tenant n\'est défini', function () {
        $middleware = new EnsureCompanyIsActive();
        $request = Request::create('/test');

        $response = $middleware->handle($request, fn () => new Response('OK'));

        expect($response->getContent())->toBe('OK');
    });

    test('laisse passer si le tenant est actif', function () {
        $company = Company::factory()->create(['active' => true]);
        app()->instance('currentTenant', $company);

        $middleware = new EnsureCompanyIsActive();
        $request = Request::create('/test');

        $response = $middleware->handle($request, fn () => new Response('OK'));

        expect($response->getContent())->toBe('OK');
    });

    test('redirige vers le dashboard si le tenant est inactif', function () {
        $company = Company::factory()->create(['active' => false]);
        app()->instance('currentTenant', $company);

        $middleware = new EnsureCompanyIsActive();
        $request = Request::create('/test');

        $response = $middleware->handle($request, fn () => new Response('OK'));

        expect($response->isRedirect())->toBeTrue();
        expect($response->getTargetUrl())->toContain('dashboard');
    });

    test('ajoute company_inactive à la session après redirection', function () {
        $company = Company::factory()->create(['active' => false]);
        app()->instance('currentTenant', $company);

        $middleware = new EnsureCompanyIsActive();
        $request = Request::create('/test');

        $response = $middleware->handle($request, fn () => new Response('OK'));

        expect($response->isRedirect())->toBeTrue();
        expect(session('company_inactive'))->toBeTrue();
    });
});
