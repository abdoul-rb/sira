<?php

declare(strict_types=1);

use App\Http\Middleware\TenantMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Models\Company;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Route::bind('tenant', fn(string $value) => Company::where('slug', $value)->firstOrFail());
            /* Route::bind('tenant', function (string $value) {
                $company = Company::where('slug', $value)->first();
                
                if (!$company) {
                    \Log::error("Tenant not found", [
                        'slug' => $value,
                        'all_slugs' => Company::pluck('slug')->toArray(),
                    ]);
                    abort(404, "Entreprise '{$value}' introuvable");
                }
                
                return $company;
            }); */
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tenant' => TenantMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
