<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

final class TenantMiddleware
{
    /**
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('auth.login');
        }

        /**
         * @var User $user
         */
        $user = Auth::user();

        if (! $user->member) {
            abort(403, "Votre compte n'est associé à aucun membre.");
        }

        if (! $user->member->company) {
            abort(403, "Vous n'êtes associé à aucune entreprise.");
        }

        $tenant = $request->route('tenant');

        if (is_string($tenant)) {
            $tenant = Company::where('slug', $tenant)->firstOrFail();
        }

        if (is_null($tenant)) {
            throw new NotFoundHttpException('Tenant parameter is required');
        }

        $userCompany = $user->member->company;

        if ($tenant->id !== $userCompany->id) {
            Log::warning("Tentative d'accès non autorisé à un autre tenant", [
                'user_id' => $user->id,
                'user_company_slug' => $userCompany->slug,
                'attempted_tenant_slug' => $tenant->slug,
                'ip_address' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            throw new NotFoundHttpException("Access denied ...");

            /* return redirect()
                ->route('dashboard.index', ['tenant' => $userCompany])
                ->with('error', 'Accès Denied to previously url.'); */
        }

        // dd($tenant);
        // Stocker l'entreprise courante dans l'application (accessible partout)
        app()->instance('currentTenant', $tenant ?? $user->member->company);

        if ($tenant && Schema::hasTable('companies')) {
            View::share('currentTenant', $tenant);
        }

        // Configuration de l'URL pour inclure automatiquement le tenant
        app('url')->defaults(['tenant' => $tenant]);

        // Injecter la company tenant dans la requête pour le Route Model Binding
        $request->route()->setParameter('tenant', $tenant);

        // Ajout du tenant dans les logs
        Log::withContext(['tenant' => $tenant->slug]);

        return $next($request);
    }
}
