@props(['tenant'])

<x-ui.modals.base id="upgrade-pro" size="md">
    <x-slot:title>
        {{ __('Passez à Pro pour continuer') }}
    </x-slot:title>

    <div>
        <p class="text-sm text-gray-600">
            {{ __('Vous avez atteint la limite du nombre de produits') }}
        </p>

        <div
            class="mt-8 relative rounded-xl border border-blue-200 bg-gradient-to-br from-blue-200/5 to-transparent p-5">
            <div class="absolute -top-3 left-4">
                <div
                    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 border-transparent hover:bg-blue-100/80 bg-blue-100 text-blue-600 gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-sparkles h-3 w-3">
                        <path
                            d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z">
                        </path>
                        <path d="M20 3v4"></path>
                        <path d="M22 5h-4"></path>
                        <path d="M4 17v2"></path>
                        <path d="M5 18H3"></path>
                    </svg>
                    Recommandé
                </div>
            </div>
            <div class="flex items-baseline gap-1 mb-4 mt-2">
                <span class="text-2xl font-semibold text-black">
                    {{ Number::currency(config('app.price'), in: 'XOF', locale: 'fr') }}
                </span>
                <span class="text-xs text-gray-500">/utilisateur/mois</span>
            </div>
            <ul class="space-y-3">
                <li class="flex items-center gap-3 text-sm">
                    <div class="p-1 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-3 w-3 text-blue-600">
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Produits illimités</span>
                </li>
                <li class="flex items-center gap-3 text-sm">
                    <div class="p-1 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-3 w-3 text-blue-600">
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Tableau de bord avancé</span>
                </li>
                <li class="flex items-center gap-3 text-sm">
                    <div class="p-1 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-3 w-3 text-blue-600">
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Analytics détaillées</span>
                </li>
                <li class="flex items-center gap-3 text-sm">
                    <div class="p-1 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-3 w-3 text-blue-600">
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Support prioritaire</span>
                </li>
                <li class="flex items-center gap-3 text-sm">
                    <div class="p-1 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-3 w-3 text-blue-600">
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">Export des données</span>
                </li>
                <li class="flex items-center gap-3 text-sm">
                    <div class="p-1 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-3 w-3 text-blue-600">
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                    </div>
                    <span class="text-gray-700">API access</span>
                </li>
            </ul>
        </div>

        <a href="{{ route('checkout.index', ['company' => $tenant]) }}"
            class="mt-6 w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-1.5 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-gray-900 cursor-pointer">
            {{ __('Passer à Pro maintenant') }}
        </a>

        <p class="text-center text-xs text-gray-600 mt-4">
            Annulez à tout moment • Paiement sécurisé par Stripe
        </p>
    </div>
</x-ui.modals.base>