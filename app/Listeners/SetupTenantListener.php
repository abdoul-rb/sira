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
    public function __construct(protected Application $app) {}

    public function handle(RouteMatched $event): void
    {
        // Cached this query
        $companies = Cache::remember('companies', 60 * 60, function () {
            return Company::all()->pluck('slug')->toArray();
        });

        $tenant = $event->route->parameter('tenant');

        if (is_null($tenant)) {
            return;
        }

        if (!in_array($tenant, $companies)) {
            throw new NotFoundHttpException("Tenant not found");
        }

        $this->app['url']->defaults(['tenant' => $tenant]);

        Log::withContext(['tenant' => $tenant]);
    }
}
