@section('title', 'Commandes')

<div class="space-y-5" x-data="{
    init() {
        Livewire.on('order-created', () => {
            $wire.$refresh()
        })
    }
}">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Toutes les ventes') }}
        </h1>

        <div class="flex items-center gap-x-2">
            <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'create-order' })">
                {{ __('Ajouter une vente') }}
            </x-ui.btn.primary>

            <div class="relative inline-block text-left" x-data="{ openMore: false }">
                <div class="inline-flex divide-x divide-gray-200 rounded-md border border-gray-100">
                    <div
                        class="inline-flex items-center gap-x-1.5 rounded-l-md bg-white px-4 py-1.5 text-black text-sm">
                        Plus
                    </div>
                    <button @click="openMore = !openMore"
                        class="inline-flex items-center rounded-l-none rounded-r-md bg-white p-1.5 focus:outiline-none focus-visible:ring-offset-gray-50 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon" class="size-5 text-black">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </button>
                </div>
                <div x-show="openMore"
                    class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 transition focus:outline-hidden data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                    <div class="py-1" role="none">
                        <a href="#"
                            class="flex justify-between px-4 py-2 text-sm text-gray-700 data-focus:bg-gray-100 data-focus:text-gray-900 data-focus:outline-hidden hover:bg-gray-50">
                            <span>Consultations des achats</span>
                        </a>
                        <a href="#"
                            class="flex justify-between px-4 py-2 text-sm text-gray-700 data-focus:bg-gray-100 data-focus:text-gray-900 data-focus:outline-hidden hover:bg-gray-50">
                            <span>Consultations</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de création de produit -->
    <x-ui.modals.create-order-modal :tenant="$tenant" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <x-ui.cards.trending-stat label="Nombre de ventes" :value="$orders->count()">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat label="Crédits" :value="$creditsOrdersCount">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat label="Montants totals" :value="Number::currency($totalSales, in: 'XOF', locale: 'fr')">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>
    </div>

    {{-- @dump(current_tenant()) --}}

    <!-- Filters -->
    <div class="rounded-lg border border-gray-200 bg-white p-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div>
                <x-form.label label="Période" id="date-filter" />
                <div class="mt-1">
                    <select wire:model.live="dateFilter" id="date-filter" required
                        class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
                        @foreach ($periods as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                @error('role')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($orders as $order)
            <x-ui.cards.order-card :order="$order" />
        @empty
            <div class="col-span-full">
                <div class="text-center text-gray-400 py-8">
                    Aucune commande trouvée.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>


    <!-- Ancien table list des commandes -->
    {{-- <div class="col-span-full">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
            <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 /90">
                        {{ __('Dernières commandes') }}
                    </h3>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
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
                </div>
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
                                    {{ __('Montant') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Date') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Statut') }}
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
                                                stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="block font-medium text-gray-700 text-sm">
                                        {{ $order->order_number }}
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
                                    Software License
                                </span>
                            </x-ui.tables.cell>

                            <x-ui.tables.cell>
                                <span class="text-gray-700 text-sm">
                                    €
                                </span>
                            </x-ui.tables.cell>

                            <x-ui.tables.cell>
                                <span class="text-gray-700 text-sm">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </span>
                            </x-ui.tables.cell>

                            <x-ui.tables.cell>
                                <span class="{{ $order->status->color() }} text-xs rounded-full px-2 py-0.5">
                                    {{ $order->status->label() }}
                                </span>
                            </x-ui.tables.cell>

                            <x-ui.tables.cell>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('dashboard.orders.invoice', ['tenant' => current_tenant()->slug, 'order' => $order]) }}"
                                        target="_blank"
                                        class="flex items-center gap-1 text-gray-600 text-sm font-medium p-1"
                                        title="Imprimer la facture">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                        </svg>
                                    </a>

                                    <a href="#" class="flex items-center gap-1 text-blue-600 text-sm font-medium p-1">
                                        <svg class="size-5 text-blue/50 shrink-0" data-slot="icon" fill="none"
                                            stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                            </path>
                                        </svg>
                                    </a>

                                    <div>
                                        <button wire:click="confirmDelete({{ $order->id }})"
                                            class="flex items-center gap-1 text-red-600 text-sm font-medium p-1 cursor-pointer">
                                            <svg class="size-5 text-red/50 shrink-0" data-slot="icon" fill="none"
                                                stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                                </path>
                                            </svg>
                                        </button>

                                        @if ($confirmingDelete === $order->id)
                                        <div
                                            class="absolute inset-0 bg-white/80 flex flex-col items-center justify-center z-10 rounded-xl">
                                            <div class="mb-2 text-gray-700">Confirmer la suppression ?</div>
                                            <div class="flex gap-2">
                                                <button wire:click="deleteOrder({{ $order->id }})"
                                                    class="btn btn-xs btn-error ml-2">Oui, supprimer</button>
                                                <button wire:click="$set('confirmingDelete', null)"
                                                    class="btn btn-xs ml-2">Annuler</button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
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
        <!-- Table Four -->
    </div> --}}
</div>