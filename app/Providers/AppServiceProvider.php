<?php

namespace App\Providers;

use App\Listeners\SetupTenantListener;
use App\Models\Company;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Enregistrement du listener pour la configuration multi-tenant
        Event::listen(
            RouteMatched::class,
            SetupTenantListener::class
        );

        $tenantSlug = parse_url(app('url')->current(), PHP_URL_HOST) ? explode('.', parse_url(app('url')->current(), PHP_URL_HOST))[0] : null;

        if ($tenantSlug) {
            $company = Company::where('slug', $tenantSlug)->first();

            View::share('currentTenant', $company);
        }

        Blade::if('version', function (int $value) {
            return config('app.version') === $value;
        });
    }
}
