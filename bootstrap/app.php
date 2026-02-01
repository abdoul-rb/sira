<?php

declare(strict_types=1);

use App\Http\Middleware\EnsureCompanyIsActive;
use App\Http\Middleware\TenantMiddleware;
use App\Models\Company;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Binding explicite du paramètre {company} vers Company par slug
            Route::bind('company', function (string $value) {
                return \App\Models\Company::where('slug', $value)->firstOrFail();
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tenant' => TenantMiddleware::class,
            'company.active' => EnsureCompanyIsActive::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('auth.login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
