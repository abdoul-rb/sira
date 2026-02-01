{{-- @if(isset($currentTenant) && !$currentTenant->active) --}}
<div
    class="my-6 w-full bg-gradient-to-r from-red-500/10 via-red-500/5 to-red-500/10 border border-red-200 rounded-xl p-4 mb-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="p-2 bg-red-200 rounded-lg shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-5 h-5 text-red-500">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                    <path d="M12 9v4"></path>
                    <path d="M12 17h.01"></path>
                </svg>
            </div>
            @dump(auth()->user()->company())
            <div>
                <h3 class="font-semibold text-gray-900">
                    Acme Corp - Compte inactif
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    Votre entreprise est actuellement inactive. Certaines
                    fonctionnalités peuvent être limitées.
                </p>
            </div>
        </div>
        <button
            class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border bg-gray-50 rounded-md px-3 py-1.5 border-red-500/30 text-red-500 shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-4 h-4 mr-2">
                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
            </svg>
            Contacter le support
        </button>
    </div>
</div>
{{-- @endif --}}