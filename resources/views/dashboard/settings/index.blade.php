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
                <!-- TODO: componable / Find name -->
                <a href="{{ route('dashboard.settings.warehouses.index', ['tenant' => $currentTenant]) }}"
                    class="flex items-start space-x-4 rounded-lg p-3 transition duration-200 ease-in-out hover:bg-gray-50"
                    wire:navigate.hover>

                    <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white">
                        <svg class="size-6 shrink-0 text-white" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z">
                            </path>
                        </svg>
                    </div>

                    <div class="space-y-1">
                        <p class="inline-flex items-center font-medium text-black">
                            Emplacements
                        </p>
                        <p class="text-sm leading-5 text-gray-500">
                            {{ __('Gérez les emplacements où vous stockez vos produits.') }}
                        </p>
                    </div>
                </a>

                <a href="{{ route('dashboard.settings.shop', ['tenant' => $currentTenant]) }}"
                    class="flex items-start space-x-4 rounded-lg p-3 transition duration-200 ease-in-out hover:bg-gray-50"
                    wire:navigate.hover>

                    <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white">
                        <svg class="size-6 shrink-0 text-white" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                            </path>
                        </svg>
                    </div>

                    <div class="space-y-1">
                        <p class="inline-flex items-center font-medium text-black">
                            Boutique
                        </p>
                        <p class="text-sm leading-5 text-gray-500">
                            {{ __('Affichez et mettez à jour les informations de votre boutique.') }}
                        </p>
                    </div>
                </a>

            </div>
        </div>

    </div>
@endsection
