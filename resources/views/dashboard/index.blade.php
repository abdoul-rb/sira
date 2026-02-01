@extends('layouts.dashboard')

@section('title', __('Tableau de bord'))

@section('content')
    <div>
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex items-center gap-x-3">
                <div class="size-16 lg:size-20 shrink-0 rounded-full bg-black flex items-center justify-center">
                    <span class="lg:text-3xl font-medium text-white">
                        {{ auth()->user()->initials }}
                    </span>
                </div>
                <div class="lg:pt-1 text-left">
                    <p class="text-sm font-medium text-gray-600">Welcome back,</p>
                    <p class="text-xl font-bold text-gray-900 lg:text-2xl">{{ auth()->user()->name }}</p>
                    <p class="text-sm font-medium text-gray-600">{{ Auth::user()->roleLabels() }}</p>
                </div>
            </div>
            {{-- <div class="mt-5 flex lg:justify-center lg:mt-0">
                <a href="{{ route('dashboard.transactions.index') }}"
                    class="flex items-center justify-center rounded-md bg-white px-3 py-1.5 text-sm text-black shadow-xs ring-1 ring-gray-200">
                    Mouvements de caisse
                </a>
            </div> --}}
        </div>

        <div class="mt-6 grid grid-cols-12 gap-3">
            <x-ui.cards.trending-stat-big class="col-span-12 lg:col-span-5" mainLabel="Trésorerie Actuelle"
                :mainValue="Number::currency($cashBalance, in: 'XOF', locale: 'fr')" subLabel="Dépenses du mois"
                :subValue="Number::currency($monthExpenses, in: 'XOF', locale: 'fr')" :link="['label' => 'Journal', 'url' => route('dashboard.transactions.index')]">
                <x-slot:mainIcon>
                    <svg class="size-8 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3">
                        </path>
                    </svg>
                </x-slot:mainIcon>
            </x-ui.cards.trending-stat-big>

            <div class="col-span-12 gap-4 lg:col-span-7">
                <div class="grid grid-cols-3 sm:grid-cols-2 gap-x-2 gap-y-3">
                    <x-ui.cards.trending-stat-big class="col-span-full lg:col-span-1" mainLabel="Total des ventes (CA)"
                        :mainValue="Number::currency($totalSales, in: 'XOF', locale: 'fr')" subLabel="Crédit en cours"
                        :subValue="Number::currency($totalCredits, in: 'XOF', locale: 'fr')">
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

                    <x-ui.cards.trending-stat label="Nombre de commandes" :value="$totalOrders">
                        <x-slot:icon>
                            <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                                </path>
                            </svg>
                            </x-slot>
                    </x-ui.cards.trending-stat>

                    <x-ui.cards.trending-stat label="Clients" :value="$customersCount">
                        <x-slot:icon>
                            <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5"
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
                            <svg class="size-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-package">
                                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            </x-slot>
                    </x-ui.cards.trending-stat>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-y-4">
            <div class="col-span-2">
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
                    <div class="flex gap-5 px-6 mb-4 sm:flex-row items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ __('Dernières transactions') }}
                        </h3>

                        <a href="{{ route('dashboard.transactions.index') }}"
                            class="text-sm font-medium text-blue-500 hover:underline">
                            {{ __('Voir tous') }}
                        </a>
                    </div>

                    <div class="flow-root px-4 lg:px-0">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div
                                    class="overflow-hidden shadow-sm outline-1 outline-black/5 border border-black/10 lg:border-0 rounded-lg">
                                    <table class="relative min-w-full divide-y divide-gray-300">
                                        <thead class="border-gray-100 border-y bg-gray-100">
                                            <x-ui.tables.row>
                                                <x-ui.tables.heading sortable direction="asc">
                                                    <span class="font-medium text-gray-500 text-xs">
                                                        {{ __('Date') }}
                                                    </span>
                                                </x-ui.tables.heading>

                                                <x-ui.tables.heading>
                                                    <span class="font-medium text-gray-500 text-xs">
                                                        {{ __('Description') }}
                                                    </span>
                                                </x-ui.tables.heading>

                                                <x-ui.tables.heading>
                                                    <span class="font-medium text-gray-500 text-xs">
                                                        {{ __('Catégorie') }}
                                                    </span>
                                                </x-ui.tables.heading>

                                                <x-ui.tables.heading align="right">
                                                    <span class="font-medium text-gray-500 text-xs text-right">
                                                        {{ __('Montant') }}
                                                    </span>
                                                </x-ui.tables.heading>
                                            </x-ui.tables.row>
                                        </thead>

                                        <tbody class="divide-y divide-gray-100 bg-white">
                                            @forelse($transactions as $transaction)
                                                <x-ui.tables.row class="hover:bg-gray-50">
                                                    <x-ui.tables.cell>
                                                        <span class="text-gray-700 text-sm">
                                                            {{ $transaction->date->format('d M. Y') }}
                                                        </span>
                                                    </x-ui.tables.cell>

                                                    <x-ui.tables.cell>
                                                        <span class="inline-flex items-center gap-2 text-gray-700 text-sm">
                                                            @if ($transaction->type === 'in')
                                                                <div
                                                                    class="w-6 h-6 rounded flex items-center justify-center flex-shrink-0 bg-green-50">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round" class="w-3 h-3 text-green-500">
                                                                        <path d="M7 7h10v10"></path>
                                                                        <path d="M7 17 17 7"></path>
                                                                    </svg>
                                                                </div>
                                                            @elseif ($transaction->type === 'out')
                                                                <div
                                                                    class="w-6 h-6 rounded flex items-center justify-center flex-shrink-0 bg-red-50">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round" class="w-3 h-3 text-red-500">
                                                                        <path d="m7 7 10 10"></path>
                                                                        <path d="M17 7v10H7"></path>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                            {{ $transaction->label }}
                                                        </span>
                                                    </x-ui.tables.cell>

                                                    <x-ui.tables.cell>
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                                            {{ $transaction->category }}
                                                        </span>
                                                    </x-ui.tables.cell>

                                                    <x-ui.tables.cell class="text-right">
                                                        <span
                                                            class="text-gray-700 text-xs font-medium {{ $transaction->type === 'out' ? 'text-red-500' : 'text-green-500' }}">
                                                            {{ Number::currency($transaction->amount, in: 'XOF', locale: 'fr') }}
                                                        </span>
                                                    </x-ui.tables.cell>
                                                </x-ui.tables.row>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-gray-400 py-8">
                                                        Aucune transaction trouvée.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
                    <div class="flex gap-5 px-6 mb-4 sm:flex-row items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ __('Créances') }}
                        </h3>

                        <a href="{{ route('dashboard.receivables.index') }}"
                            class="text-sm font-medium text-blue-500 hover:underline">
                            {{ __('Voir tous') }}
                        </a>
                    </div>

                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                        <div class="max-w-full overflow-x-auto custom-scrollbar">
                            <table class="min-w-full">
                                <!-- table header start -->
                                <thead class="border-gray-100 border-y bg-gray-50">
                                    <x-ui.tables.row>
                                        <x-ui.tables.heading>
                                            <span class="font-medium text-gray-500 text-xs">
                                                {{ __('Client') }}
                                            </span>
                                        </x-ui.tables.heading>

                                        <x-ui.tables.heading>
                                            <span class="font-medium text-gray-500 text-xs">
                                                {{ __('Reste à payer') }}
                                            </span>
                                        </x-ui.tables.heading>
                                    </x-ui.tables.row>
                                </thead>
                                <!-- table header end -->

                                <!-- table body start -->
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($receivablesOrders as $receivable)
                                        <x-ui.tables.row class="hover:bg-gray-50">
                                            <x-ui.tables.cell>
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50">
                                                        <span class="text-xs font-semibold text-blue-500">
                                                            {{ $receivable->customer?->initials ?? '-' }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm block font-medium text-gray-700">
                                                            {{ $receivable->customer?->fullname ?? '-' }}
                                                        </span>
                                                        <span class="text-gray-500 text-xs">
                                                            {{ $receivable->customer?->email ?? '-' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </x-ui.tables.cell>

                                            <x-ui.tables.cell>
                                                <span class="text-gray-700 text-xs font-medium">
                                                    {{ Number::currency($receivable->remaining_amount, in: 'XOF', locale: 'fr') }}
                                                </span>
                                            </x-ui.tables.cell>
                                        </x-ui.tables.row>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-gray-400 py-8">
                                                Aucune créance trouvée.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <!-- table body end -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="mt-10 overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
            <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 /90">
                        {{ __('Dernières ventes') }}
                    </h3>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'create-order' })">
                        {{ __('Ajouter une vente') }}
                    </x-ui.btn.primary>

                    <!-- Modal de création de produit -->
                    <x-ui.modals.create-order-modal :tenant="$tenant" />
                </div>
            </div>

            <div class="max-w-full overflow-x-auto">
                <table class="min-w-full">
                    <!-- table header start -->
                    <thead class="border-gray-100 border-y bg-gray-50">
                        <x-ui.tables.row>
                            <x-ui.tables.heading>
                                <div x-data="{ checked: false }" class="flex items-center gap-3">
                                    <div @click="checked = !checked"
                                        class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px] bg-white /0 border-gray-300 "
                                        :class="checked ? 'border-brand-500  bg-brand-500' : 'bg-white /0 border-gray-300 '">
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
                                    {{ __('Produits') }}
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
                                        :class="checked ? 'border-brand-500  bg-brand-500' : 'bg-white /0 border-gray-300 '">
                                        <svg :class="checked ? 'block' : 'hidden'" width="14" height="14"
                                            viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                                            class="hidden">
                                            <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white"
                                                stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round">
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

                            <x-ui.tables.cell class="w-16">
                                <span class="text-gray-700 text-sm">
                                    <!-- $order->products->pluck('product.name')->implode(', ') -->
                                </span>
                            </x-ui.tables.cell>

                            <x-ui.tables.cell>
                                <span class="text-gray-700 text-sm">
                                    {{ $order->total_amount }}
                                </span>
                            </x-ui.tables.cell>

                            <x-ui.tables.cell>
                                <span class="text-gray-700 text-sm">
                                    {{ $order->created_at->format('d M. Y') }}
                                </span>
                            </x-ui.tables.cell>

                            <x-ui.tables.cell>
                                <span class="{{ $order->payment_status->color() }} text-xs rounded-full px-2 py-0.5">
                                    {{ $order->payment_status->label() }}
                                </span>
                            </x-ui.tables.cell>

                            <x-ui.tables.cell>
                                <div class="flex items-center gap-2">
                                    <a href="#" class="flex items-center gap-1 text-blue-600 text-sm font-medium p-1">
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
        </div> --}}
    </div>
@endsection