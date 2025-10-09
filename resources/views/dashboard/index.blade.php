@extends('layouts.dashboard')

@section('title', __('Tableau de bord'))

@section('content')
    <div>
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="lg:flex sm:space-x-5">
                <div class="shrink-0">
                    <img src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="" class="mx-auto size-20 rounded-full" />
                </div>
                <div class="mt-4 text-center lg:mt-0 lg:pt-1 lg:text-left">
                    <p class="text-sm font-medium text-gray-600">Welcome back,</p>
                    <p class="text-xl font-bold text-gray-900 lg:text-2xl">{{ auth()->user()->name }}</p>
                    <p class="text-sm font-medium text-gray-600">Product Designer</p>
                </div>
            </div>
            <div class="mt-5 flex justify-center lg:mt-0">
                <a href="#"
                    class="flex items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-medium text-black shadow-xs ring-1 ring-gray-200">
                    Mon profil
                </a>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-12 gap-4">
            <div class="col-span-12 gap-4 lg:col-span-7 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-ui.cards.trending-stat label="Clients" :value="$customersCount">
                        <x-slot:icon>
                            <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z">
                                </path>
                            </svg>
                        </x-slot>
                    </x-ui.cards.trending-stat>

                    <x-ui.cards.trending-stat label="Produits en stock" :value="$productsCount">
                        <x-slot:icon>
                            <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                                </path>
                            </svg>
                        </x-slot>
                    </x-ui.cards.trending-stat>
                </div>

                <x-ui.cards.trending-stat label="Nombre de commandes" :value="$totalOrders">
                    <x-slot:icon>
                        <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                            </path>
                        </svg>
                    </x-slot>
                </x-ui.cards.trending-stat>
            </div>

            <x-ui.cards.trending-stat class="col-span-12 lg:col-span-5" label="Total des ventes (revenu brut)"
                :value="Number::currency($totalSales, in: 'XOF', locale: 'fr')">
                <x-slot:icon>
                    <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z">
                        </path>
                    </svg>
                </x-slot>
            </x-ui.cards.trending-stat>
        </div>

        <div class="mt-10 overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
            <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 /90">
                        {{ __('Dernières ventes') }}
                    </h3>
                </div>

                <!-- TODO: Filtres -->
                {{-- <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <form>
                        <div class="relative">
                            <span class="absolute -translate-y-1/2 pointer-events-none top-1/2 left-4">
                                <svg class="fill-gray-500 " width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                        fill=""></path>
                                </svg>
                            </span>
                            <input type="text" placeholder="Search..."
                                class="shadow-xs focus:border-gray-300 focus:ring-gray-500/10 h-10 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-[42px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-1 focus:outline-hidden xl:w-[300px]">
                        </div>
                    </form>
                    <div>
                        <button
                            class="text-sm shadow-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800">
                            <svg class="stroke-current fill-white " width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z"
                                    fill="" stroke="" stroke-width="1.5"></path>
                                <path
                                    d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z"
                                    fill="" stroke="" stroke-width="1.5"></path>
                            </svg>

                            Filter
                        </button>
                    </div>
                </div> --}}
            </div>

            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="min-w-full">
                    <!-- table header start -->
                    <thead class="border-gray-100 border-y bg-gray-50">
                        <x-ui.tables.row>
                            <x-ui.tables.heading>
                                <div x-data="{ checked: false }" class="flex items-center gap-3">
                                    <div @click="checked = !checked"
                                        class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px] bg-white /0 border-gray-300 "
                                        :class="checked ? 'border-brand-500  bg-brand-500' :
                                            'bg-white /0 border-gray-300 '">
                                        <svg :class="checked ? 'block' : 'hidden'" width="14" height="14"
                                            viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                                            class="hidden">
                                            <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white"
                                                stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="block font-medium text-gray-500 text-xs">
                                        N°
                                    </span>
                                </div>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Client') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Product/Service') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Montant total') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Date de la commande') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Mode de paiement') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    Action
                                </span>
                            </x-ui.tables.heading>
                        </x-ui.tables.row>
                    </thead>
                    <!-- table header end -->

                    <!-- table body start -->
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <x-ui.tables.row class="hover:bg-gray-50">
                                <x-ui.tables.cell>
                                    <div x-data="{ checked: false }" class="flex items-center gap-3">
                                        <div @click="checked = !checked"
                                            class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px] bg-white /0 border-gray-300 "
                                            :class="checked ? 'border-brand-500  bg-brand-500' :
                                                'bg-white /0 border-gray-300 '">
                                            <svg :class="checked ? 'block' : 'hidden'" width="14" height="14"
                                                viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                class="hidden">
                                                <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white"
                                                    stroke-width="1.94437" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="block font-medium text-gray-700 text-sm">
                                            #{{ $order->order_number }}
                                        </span>
                                    </div>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50">
                                            <span class="text-xs font-semibold text-blue-500">
                                                {{ $order->customer?->initials ?? '-' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-sm block font-medium text-gray-700">
                                                {{ $order->customer?->fullname ?? '-' }}
                                            </span>
                                            <span class="text-gray-500 text-xs">
                                                {{ $order->customer?->email ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <span class="text-gray-700 text-sm">
                                        {{ $order->products->pluck('name')->implode(', ') }}
                                    </span>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <span class="text-gray-700 text-sm">
                                        {{ $order->total_amount }}
                                    </span>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <span class="text-gray-700 text-sm">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </span>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    {{-- <span class="{{ $order->status->color() }} text-xs rounded-full px-2 py-0.5">
                                        {{ $order->status->label() }}
                                    </span> --}}
                                    <p class="mt-1 flex items-center gap-1 text-xs font-medium text-black">
                                        <span
                                            class="inline-block w-2 h-2 rounded-full {{ $order->payment_status->color() }}"></span>
                                        {{ $order->payment_status->label() }}
                                    </p>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('dashboard.orders.edit', [$tenant, $order]) }}"
                                            class="flex items-center gap-1 text-blue-600 text-sm font-medium p-1">
                                            <svg class="size-5 text-blue/50 shrink-0" data-slot="icon" fill="none"
                                                stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </x-ui.tables.cell>
                            </x-ui.tables.row>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400 py-8">
                                    Aucune commande trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <!-- table body end -->
                </table>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-12 gap-4 md:gap-6">

            <!-- Dernières commandes -->
            <div class="col-span-full">

                <!-- Table Four -->
            </div>

            <div class="col-span-full">
                <h3 class="text-lg font-semibold text-gray-800 /90">
                    {{ __('Suivi des ventes') }}
                </h3>

                <h3 class="text-lg font-semibold text-gray-800 /90">
                    {{ __('Suivi des crédits') }}
                </h3>
            </div>
        </div>
    </div>
@endsection
