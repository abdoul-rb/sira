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
        // Récupération du paramètre tenant (slug)
        $tenantSlug = $event->route->parameter('tenant');

        if (is_null($tenantSlug)) {
            return;
        }

        // Récupération des tenants depuis le cache
        $companies = $this->getCachedCompanies();

        // Vérification que le tenant existe
        if (!in_array($tenantSlug, $companies)) {
            throw new NotFoundHttpException("Tenant '{$tenantSlug}' not found");
        }

        // Configuration de l'URL pour inclure automatiquement le tenant
        $this->app['url']->defaults(['tenant' => $tenantSlug]);

        // Ajout du tenant dans les logs pour faciliter le debugging
        Log::withContext(['tenant' => $tenantSlug]);
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
