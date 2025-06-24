<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Routing\Events\RouteMatched;
use App\Models\Company;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Log;

class SetupTenantListener
{    
    /**
     * Durée de cache pour la liste des tenants (30 minutes)
     */
    private const CACHE_TTL = 1800;

    public function __construct(protected Application $app) {}

    public function handle(RouteMatched $event): void
    {
        $tenant = $event->route->parameter('tenant');

        if (is_null($tenant)) {
            return;
        }

        $companies = $this->getCachedCompanies();

        if (!in_array($tenant, $companies)) {
            throw new NotFoundHttpException("Tenant '{$tenant}' not found");
        }

        // Configuration de l'URL pour inclure automatiquement le tenant
        $this->app['url']->defaults(['tenant' => $tenant]);

        // Ajout du tenant dans les logs pour faciliter le debugging
        Log::withContext(['tenant' => $tenant]);
    }

    /**
     * Récupère la liste des tenants depuis le cache
     */
    private function getCachedCompanies(): array
    {
        return Cache::remember(
            'tenant_companies_slugs', 
            self::CACHE_TTL, 
            fn() => Company::where('active', true)
                    ->pluck('slug')
                    ->toArray()
        );
    }
}
