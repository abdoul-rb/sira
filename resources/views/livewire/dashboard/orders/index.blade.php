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
        <x-ui.cards.trending-stat class="col-span-full" label="Montants totals" :value="Number::currency($totalSales, in: 'XOF', locale: 'fr')">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat class="col-span-1" label="Nombre de ventes" :value="$orders->count()">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat class="col-span-1" label="Crédits" :value="$creditsOrdersCount">
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