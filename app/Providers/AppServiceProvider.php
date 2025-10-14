<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\SetupTenantListener;
use App\Models\Company;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Carbon\Carbon;
use Opcodes\LogViewer\Facades\LogViewer;

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

        // résout tenant depuis subdomain / cherche le tenant dans le sous-domaine
        $tenantSlug = parse_url(app('url')->current(), PHP_URL_HOST)
            ? explode('.', parse_url(app('url')->current(), PHP_URL_HOST))[0]
            : null;

        if ($tenantSlug && Schema::hasTable('companies')) {
            $company = Company::where('slug', $tenantSlug)->first();

            View::share('currentTenant', $company);
        }

        Blade::if('version', function (int $value) {
            return config('app.version') === $value;
        });

        Event::listen(Login::class, function ($event) {
            $event->user->update([
                'last_login_at' => Carbon::now(),
                'last_login_ip' => request()->ip(),
            ]);
        });

        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->email, explode(',', config('auth.admin_emails')));
        });
    }
}
