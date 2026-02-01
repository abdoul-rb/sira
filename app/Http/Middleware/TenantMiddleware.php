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

        // Le paramètre est maintenant 'company' grâce au Route Model Binding implicite
        $company = $request->route('company');

        if (is_null($company)) {
            throw new NotFoundHttpException('Company parameter is required');
        }

        // Si c'est une string (ne devrait plus arriver avec le binding implicite), on résout
        if (is_string($company)) {
            $company = Company::where('slug', $company)->firstOrFail();
        }

        $userCompany = $user->member->company;

        if ($company->id !== $userCompany->id) {
            Log::warning("Tentative d'accès inter-tenant bloquée", [
                'user_id' => $user->id,
                'user_company' => $userCompany->slug,
                'target_company' => $company->slug,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);

            throw new NotFoundHttpException('Access denied.');
        }

        // Rendre le tenant disponible pour toute l'application
        app()->instance('currentTenant', $company);

        // Injection dans toutes les vues
        if (! app()->runningInConsole()) {
            View::share('currentTenant', $company);
        }

        // Configurer les URLs pour ne plus avoir à passer ['company' => ...]
        app('url')->defaults(['company' => $company]);

        // Contextualiser les Logs
        Log::withContext(['tenant_slug' => $company->slug]);

        return $next($request);
    }
}
