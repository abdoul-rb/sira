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
                {{ __('Nouvelle vente') }}
            </x-ui.btn.primary>

            <a href="{{ route('dashboard.receivables.index', ['tenant' => $tenant]) }}" wire:navigate
                class="flex items-center justify-center rounded-md bg-white px-3 py-1.5 text-sm text-black shadow-xs ring-1 ring-gray-200">
                Consulter les créances
            </a>

            {{-- <div class="relative inline-block text-left" x-data="{ openMore: false }">
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
                        <a href="{{ route('dashboard.receivables.index', ['tenant' => $tenant]) }}" wire:navigate
                            class="flex justify-between px-4 py-2 text-sm text-gray-700 focus:text-gray-900 focus:outline-hidden hover:bg-gray-100">
                            <span>Consulter les créances</span>
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Modal de création de produit -->
    <x-ui.modals.create-order-modal :tenant="$tenant" />

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4">
        <x-ui.cards.trending-stat class="col-span-1" label="Nombre de ventes" :value="$orders->count()">
            <x-slot:icon>
                <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="2" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat class="col-span-1" label="Chiffres d'affaires" :value="Number::currency($totalSales, in: 'XOF', locale: 'fr')">
            <x-slot:icon>
                <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat class="col-span-1" label="Encaissé" :value="$orders->count()">
            <x-slot:icon>
                <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat class="col-span-1" label="Crédits" :value="$creditsOrdersCount">
            <x-slot:icon>
                <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

    </div>

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
</div>