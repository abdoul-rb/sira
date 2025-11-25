<?php

declare(strict_types=1);

use App\Http\Middleware\TenantMiddleware;
use App\Models\Company;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// Helper pour lancer le middleware
function runMiddleware(Request $request) {
    return (new TenantMiddleware())->handle($request, function ($req) {
        return response('OK');
    });
}

test('redirects to login if not authenticated', function () {
    $request = Request::create('/test', 'GET');
    $response = runMiddleware($request);
    
    expect($response->getStatusCode())->toBe(302);
});

test('aborts 403 if user has no member/company association', function () {
    $user = User::factory()->create(); // User orphelin
    $user->load('member');
    Auth::login($user);

    $request = Request::create('/test', 'GET');

    expect(fn() => runMiddleware($request))
        ->toThrow(HttpException::class, "Votre compte n'est associé à aucune entreprise.");
});

test('denies access if user tries to access another tenant url', function () {
    // Scénario : Je suis chez Apple, je tente d'accéder à /microsoft/dashboard
    $myCompany = Company::factory()->create(['slug' => 'apple']);
    $otherCompany = Company::factory()->create(['slug' => 'microsoft']);

    $user = User::factory()->create();
    $member = Member::factory()->create(['user_id' => $user->id, 'company_id' => $myCompany->id]);
    
    // Important : Recharger la relation pour que Auth::user()->member->company soit dispo
    $user->setRelation('member', $member);
    $member->setRelation('company', $myCompany);

    Auth::login($user);

    // Requête vers Microsoft
    $request = Request::create('/microsoft/dashboard', 'GET');
    
    // Simulation du Route Model Binding qui a trouvé 'Microsoft'
    $route = Route::newRoute(['GET'], '/{tenant}/dashboard', ['uses' => fn() => 'ok']);
    $route->bind($request);
    $route->setParameter('tenant', $otherCompany);
    $request->setRouteResolver(fn() => $route);

    expect(fn() => runMiddleware($request))->toThrow(NotFoundHttpException::class);
});

test('allows access and sets context if tenant matches user company', function () {
    $company = Company::factory()->create(['slug' => 'apple']);
    $user = User::factory()->create();
    $member = Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);
    
    $user->setRelation('member', $member);
    $member->setRelation('company', $company);
    
    Auth::login($user);

    $request = Request::create('/apple/dashboard', 'GET');
    
    $route = Route::newRoute(['GET'], '/{tenant}/dashboard', ['uses' => fn() => 'ok']);
    $route->bind($request);
    $route->setParameter('tenant', $company);
    $request->setRouteResolver(fn() => $route);

    $response = runMiddleware($request);

    expect($response->getContent())->toBe('OK');
    
    // Vérifier que le middleware a bien fait son job
    expect(app('currentTenant')->id)->toBe($company->id);
    expect(app('url')->getDefaultParameters()['tenant']->id)->toBe($company->id);
});