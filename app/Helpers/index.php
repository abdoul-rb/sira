<?php

declare(strict_types=1);

use App\Models\Company;

// require __DIR__ . '/format.php';

if (! function_exists('current_tenant')) {
    function current_tenant(): ?Company
    {
        if (app()->bound('currentTenant')) {
            return resolve('currentTenant');
        }

        if (Auth::check()) {
            $user = Auth::user();

            if (! $user->relationLoaded('member')) {
                $user->load(['member' => function ($query) {
                    $query->withoutGlobalScope(\App\Models\Scopes\TenantScope::class);
                }]);
            }

            return $user->getRelation('member')?->company;
        }

        return null;
    }
}

if (! function_exists('tenant_route')) {
    function tenant_route($name, $parameters = [], $absolute = true)
    {
        return route($name, array_merge(['company' => current_tenant()], $parameters), $absolute);
    }
}

if (! function_exists('app_version')) {
    function app_version(): int
    {
        return (int) config('app.version');
    }
}

if (! function_exists('is_version')) {
    function is_version(int $version): bool
    {
        return app_version() === $version;
    }
}
