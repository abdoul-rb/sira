@section('title', __('Tableau de bord'))

<div x-data="{ open: false }" @keydown.window.escape="open = false">
    <main class="pt-8 pb-24 bg-gray-50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-4 xl:px-0">
            <div class="lg:flex lg:items-center lg:justify-between mb-8">
                <div class="flex items-center gap-x-3">
                    <div class="size-16 lg:size-20 shrink-0 rounded-full bg-black flex items-center justify-center">
                        <span class="lg:text-3xl font-medium text-white">
                            AB {{-- {{ auth()->user()->initials }} --}}
                        </span>
                    </div>
                    <div class="lg:pt-1 text-left">
                        <p class="text-sm font-medium text-gray-600">Welcome back,</p>
                        <p class="text-xl font-bold text-gray-900 lg:text-2xl">
                            Abdoul Rahim{{-- {{ auth()->user()->name }} --}}
                        </p>
                        <p class="text-sm font-medium text-gray-600">
                            Manager{{-- {{ Auth::user()->roleLabels() }} --}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-12 gap-3 mb-8">
                <x-ui.cards.trending-stat-big class="col-span-12 lg:col-span-5" mainLabel="Trésorerie Actuelle"
                    :mainValue="Number::currency(0, in: 'XOF', locale: 'fr')" subLabel="Dépenses du mois"
                    :subValue="Number::currency(0, in: 'XOF', locale: 'fr')" :link="['label' => 'Journal', 'url' => '#']">
                    <x-slot:mainIcon>
                        <svg class="size-8 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3">
                            </path>
                        </svg>
                    </x-slot:mainIcon>
                </x-ui.cards.trending-stat-big>

                <div class="col-span-12 gap-4 lg:col-span-7">
                    <div class="grid grid-cols-3 sm:grid-cols-2 gap-x-2 gap-y-3">
                        <x-ui.cards.trending-stat-big class="col-span-full lg:col-span-1"
                            mainLabel="Total des ventes (CA)" :mainValue="Number::currency(0, in: 'XOF', locale: 'fr')"
                            subLabel="Crédit en cours" :subValue="Number::currency(0, in: 'XOF', locale: 'fr')">
                            <x-slot:mainIcon>
                                <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z">
                                    </path>
                                </svg>
                            </x-slot:mainIcon>
                        </x-ui.cards.trending-stat-big>

                        <x-ui.cards.trending-stat label="Nombre de commandes" :value="0">
                            <x-slot:icon>
                                <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                                    </path>
                                </svg>
                            </x-slot:icon>
                        </x-ui.cards.trending-stat>

                        <x-ui.cards.trending-stat label="Clients" :value="0">
                            <x-slot:icon>
                                <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z">
                                    </path>
                                </svg>
                            </x-slot:icon>
                        </x-ui.cards.trending-stat>

                        <x-ui.cards.trending-stat label="Produits en stock" :value="0">
                            <x-slot:icon>
                                <svg class="size-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-package">
                                    <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </x-slot:icon>
                        </x-ui.cards.trending-stat>
                    </div>
                </div>
            </div>

            <!-- Modale inscription + onboarding unifiée -->
            <livewire:dashboard.register-onboarding-wizard />
        </div>
    </main>
</div>