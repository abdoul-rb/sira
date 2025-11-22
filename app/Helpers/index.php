<?php

declare(strict_types=1);

use App\Models\Company;

// require __DIR__ . '/format.php';

if (!function_exists('current_tenant')) {
    function current_tenant(): ?Company
    {
        if (app()->bound('currentTenant')) {
            return resolve('currentTenant');
        }

        if (Auth::check() && Auth::user()->member && Auth::user()->member->company) {
            return Auth::user()->member->company;
        }

        return null;
    }
}

if (!function_exists('tenant_route')) {
    function tenant_route($name, $parameters = [], $absolute = true) {
        // $tenant = request()->route('tenant');
        return route($name, array_merge(['tenant' => current_tenant()], $parameters));

        if ($tenant) {
            // Si c'est déjà un objet Company, on le passe
            if ($tenant instanceof Company) {
                $parameters = array_merge(['tenant' => current_tenant()], $parameters);
            } else {
                // Si c'est un slug (string), on tente de retrouver l'objet Company
                $company = Company::where('slug', $tenant)->first();
                $parameters = array_merge(['tenant' => $company ?: $tenant], $parameters);
            }
        }

        return route($name, $parameters, $absolute);
        // return route($name, array_merge(['tenant' => current_tenant()], $parameters));
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