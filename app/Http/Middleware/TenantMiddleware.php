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

final class TenantMiddleware
{
    /**
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantSlug = $request->route('tenant');

        if (is_null($tenantSlug)) {
            throw new NotFoundHttpException('Tenant parameter is required');
        }

        $company = Company::where('slug', $tenantSlug)->where('active', true)->first();

        if (!$company) {
            throw new NotFoundHttpException("Tenant '{$tenantSlug}' not found or inactive");
        }

        // Vérifier que l'utilisateur connecté appartient à cette company
        if (Auth::check()) {
            $user = Auth::user();
            
            // Les super admins peuvent accéder à toutes les companies
            if (!$user->isSuperAdmin() && $user->company_id !== $company->id) {
                throw new NotFoundHttpException("Access denied to tenant '{$tenantSlug}'");
            }
        }

        // Injecter la company dans la requête pour le Route Model Binding
        $request->route()->setParameter('tenant', $company);

        // Configuration de l'URL pour inclure automatiquement le tenant
        app('url')->defaults(['tenant' => $tenantSlug]);

        // Ajout du tenant dans les logs
        Log::withContext(['tenant' => $tenantSlug]);

        return $next($request);
    }
}
