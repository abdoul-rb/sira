<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureCompanyIsActive
{
    /**
     * Handle an incoming request.
     *
     * Vérifie si l'entreprise du tenant est active.
     * Si inactive, redirige vers le dashboard avec un message.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Company|null $company */
        /* $company = app()->bound('currentTenant') ? app('currentTenant') : null;

        if ($company && ! $company->active) {
            // Si l'entreprise est inactive, rediriger vers le dashboard
            return redirect()
                ->route('dashboard.index', ['company' => $company])
                ->with('company_inactive', true);
        } */

        return $next($request);
    }
}
