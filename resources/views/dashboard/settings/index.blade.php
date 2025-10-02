@extends('layouts.dashboard')

@section('title', __('Paramètres'))

@section('content')
    <div class="lg:px-6">
        <h2 class="font-heading text-2xl font-bold leading-6 text-black sm:truncate sm:text-3xl sm:leading-9">
            Paramètres
        </h2>
        <!-- Header -->

        <div class="mt-8 p-4 bg-white rounded-xl ring-1 ring-gray-200">
            <div class="grid gap-4 sm:grid-cols-3 sm:gap-x-6 sm:gap-y-4">
                <x-ui.cards.settings-card-link :route="route('dashboard.settings.warehouses.index', ['tenant' => $currentTenant])" title="Général"
                    description="Gérez les informations de votre entreprise.">
                    <x-slot:icon>
                        <svg class="size-6 shrink-0 text-white" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z">
                            </path>
                        </svg>
                    </x-slot:icon>
                </x-ui.cards.settings-card-link>

                <x-ui.cards.settings-card-link :route="route('dashboard.settings.warehouses.index', ['tenant' => $currentTenant])" title="Emplacements"
                    description="Gérez les emplacements où vous stockez vos produits.">
                    <x-slot:icon>
                        <svg class="size-6 shrink-0 text-white" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z">
                            </path>
                        </svg>
                    </x-slot:icon>
                </x-ui.cards.settings-card-link>

                <x-ui.cards.settings-card-link :route="route('dashboard.settings.shop', ['tenant' => $currentTenant])" title="Boutique"
                    description="Affichez et mettez à jour les informations de votre boutique.">
                    <x-slot:icon>
                        <svg class="size-6 shrink-0 text-white" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                            </path>
                        </svg>
                    </x-slot:icon>
                </x-ui.cards.settings-card-link>

                <x-ui.cards.settings-card-link :route="route('dashboard.settings.suppliers.index', ['tenant' => $currentTenant])" title="Fournisseurs"
                    description="Gérez les fournisseurs de vos produits.">
                    <x-slot:icon>
                        <svg class="size-6 shrink-0 text-white" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z">
                            </path>
                        </svg>
                    </x-slot:icon>
                </x-ui.cards.settings-card-link>
            </div>
        </div>

    </div>
@endsection
