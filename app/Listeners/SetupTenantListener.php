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

        // 2. Cas où Laravel a déjà fait le travail (Route Model Binding)
        if ($tenantSlug instanceof Company) {
            $this->bindToContainer($tenantSlug);
            return;
        }

        // 3. Vérification rapide via Cache (Liste des slugs actifs)
        $activeSlugs = $this->getCachedCompaniesSlugs();

        // Vérification que le tenant existe
        if (! in_array($tenantSlug, $activeSlugs)) {
            throw new NotFoundHttpException("Tenant '{$tenantSlug}' not found or inactive.");
        }

        // 4. Récupération de l'objet complet avec Cache individuel
        $company = Cache::remember(
            "tenant_company_{$tenantSlug}",
            self::CACHE_TTL,
            fn () => Company::where('slug', $tenantSlug)->firstOrFail()
        );

        // 5. CRUCIAL : On rend le tenant disponible pour toute l'application
        $this->bindToContainer($company);
        
        // Optionnel : Mettre à jour le paramètre de route pour que les contrôleurs reçoivent l'objet Company et non le string
        $event->route->setParameter('tenant', $company);
    }

    /**
     * Récupère la liste des tenants depuis le cache
     */
    private function getCachedCompaniesSlugs(): array
    {
        return Cache::remember(
            'tenant_companies_slugs',
            self::CACHE_TTL,
            fn () => Company::where('active', true)->pluck('slug')->toArray()
        );
    }

    private function bindToContainer(Company $company): void
    {
        // Permet d'utiliser app('currentTenant') n'importe où
        $this->app->instance('currentTenant', $company);
        
        // Permet d'utiliser l'injection de dépendance Company dans les constructeurs si besoin
        $this->app->instance(Company::class, $company);
    }
}
