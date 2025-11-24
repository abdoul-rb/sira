<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetupTenantListener
{
    /**
     * Durée de cache pour la liste des tenants (30 minutes)
     */
    private const CACHE_TTL = 1800;

    public function __construct(protected Application $app) {}

    // https://laravel-france.com/posts/votre-application-multi-tenant-avec-laravel-sans-package-tiers
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
        if (! in_array($tenantSlug, $companies)) {
            throw new NotFoundHttpException("Tenant '{$tenantSlug}' not found");
        }

        if ($tenantSlug instanceof Company) {
            $company = $tenantSlug;

            return;
        } else {
            $slug = $tenantSlug;
            $company = Cache::remember("tenant_company_{$slug}", self::CACHE_TTL, fn () => Company::where('slug', $slug)->first());
        }

        // Exposer le tenant globalement
        // $this->app->instance('currentTenant', $company);
        // View::share('currentTenant', $company);

        // Configuration de l'URL pour inclure automatiquement le tenant
        // $this->app['url']->defaults(['tenant' => $company]);

        // Ajout du tenant dans les logs pour faciliter le debugging
        // Log::withContext(['tenant' => $company]);
    }

    /**
     * Récupère la liste des tenants depuis le cache
     */
    private function getCachedCompanies(): array
    {
        return Cache::remember(
            'tenant_companies_slugs',
            self::CACHE_TTL,
            fn () => Company::where('active', true)
                ->pluck('slug')
                ->toArray()
        );
    }
}
