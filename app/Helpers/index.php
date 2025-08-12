<?php

declare(strict_types=1);

use App\Models\Company;

// require __DIR__ . '/format.php';

if (!function_exists('current_tenant')) {
    function current_tenant(): ?Company
    {
        return app()->bound('currentTenant') ? app('currentTenant') : null;
    }
}

if (!function_exists('tenant_route')) {
    function tenant_route($name, $parameters = [], $absolute = true) {
        $tenant = request()->route('tenant');

        if ($tenant) {
            // Si c'est déjà un objet Company, on le passe
            if ($tenant instanceof Company) {
                $parameters = array_merge(['tenant' => $tenant], $parameters);
            } else {
                // Si c'est un slug (string), on tente de retrouver l'objet Company
                $company = Company::where('slug', $tenant)->first();
                $parameters = array_merge(['tenant' => $company ?: $tenant], $parameters);
            }
        }

        return route($name, $parameters, $absolute);
    }
}

if (!function_exists('app_version')) {
    function app_version(): int {
        return (int) config('app.version');
    }
}

if (!function_exists('is_version')) {
    function is_version(int $version): bool {
        return app_version() === $version;
    }
}