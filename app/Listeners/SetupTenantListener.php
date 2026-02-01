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
        // Récupération du paramètre company (slug) - maintenant via Route Model Binding implicite
        $company = $event->route->parameter('company');

        if (is_null($company)) {
            return;
        }

        // Cas où Laravel a déjà fait le travail (Route Model Binding implicite)
        if ($company instanceof Company) {
            $this->bindToContainer($company);

            return;
        }

        // Fallback: si c'est encore une string (ne devrait plus arriver), on résout manuellement
        $companySlug = $company;

        // Vérification rapide via Cache (Liste des slugs actifs)
        $activeSlugs = $this->getCachedCompaniesSlugs();

        // Vérification que la company existe
        if (! in_array($companySlug, $activeSlugs)) {
            throw new NotFoundHttpException("Company '{$companySlug}' not found or inactive.");
        }

        // Récupération de l'objet complet avec Cache individuel
        $companyModel = Cache::remember(
            "tenant_company_{$companySlug}",
            self::CACHE_TTL,
            fn () => Company::where('slug', $companySlug)->firstOrFail()
        );

        // CRUCIAL : On rend le tenant disponible pour toute l'application
        $this->bindToContainer($companyModel);

        // Mettre à jour le paramètre de route pour que les contrôleurs reçoivent l'objet Company
        $event->route->setParameter('company', $companyModel);
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
