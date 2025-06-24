<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use App\Listeners\SetupTenantListener;

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
        // Enregistrement du listener pour la configuration multi-tenant
        $this->app['events']->listen(
            RouteMatched::class,
            SetupTenantListener::class
        );
    }
}
