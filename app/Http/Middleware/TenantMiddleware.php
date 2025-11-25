<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        /** @var User $user */
        $user = Auth::user();

        if (! $user->member || ! $user->member->company) {
            abort(403, "Votre compte n'est associé à aucune entreprise.");
        }

        $tenant = $request->route('tenant');

        if (is_null($tenant)) {
            // Cas rare si le middleware est mal placé sur une route sans {tenant}
            throw new NotFoundHttpException('Tenant parameter is required');
        }

        if (is_string($tenant)) {
            $tenant = Company::where('slug', $tenant)->firstOrFail();
        }

        $userCompany = $user->member->company;

        if ($tenant->id !== $userCompany->id) {
            Log::warning("Tentative d'accès inter-tenant bloquée", [
                'user_id' => $user->id,
                'user_company' => $userCompany->slug,
                'target_tenant' => $tenant->slug,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);

            throw new NotFoundHttpException('Access denied.');
        }

        // On écrase l'instance si le Listener l'avait déjà mise, pour être sûr d'avoir la version validée par le middleware
        app()->instance('currentTenant', $tenant);

        // Injection dans toutes les vues
        if (! app()->runningInConsole()) {
            View::share('currentTenant', $tenant);
        }

        // Configurer les URLs pour ne plus avoir à passer ['tenant' => ...]
        app('url')->defaults(['tenant' => $tenant]);

        // Injecter la company tenant dans la requête pour le Route Model Binding
        $request->route()->setParameter('tenant', $tenant);

        // Mettre à jour la route pour le Route Model Binding suivant
        $request->route()->setParameter('tenant', $tenant);

        // Contextualiser les Logs
        Log::withContext(['tenant_slug' => $tenant->slug]);

        return $next($request);
    }
}
