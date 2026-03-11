@section('title', 'Créances')

<div class="space-y-5" x-data="{
    init() {
        Livewire.on('credit-updated', () => $wire.$refresh())
    }
}">
    <x-ui.breadcrumb :items="[
        ['label' => 'Ventes', 'url' => route('dashboard.orders.index', ['tenant' => $tenant->slug])],
        ['label' => 'Créances', 'url' => '#'],
    ]" />

    <div>
        <h1 class="text-2xl font-bold text-black">{{ __('Créances') }}</h1>
        <p class="text-gray-500 text-sm">Suivi des impayés clients</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
        <x-ui.cards.trending-stat label="Nombre de créances" :value="$credits->total()">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                </svg>
            </x-slot:icon>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat label="Total en attente" :value="Number::currency($totalReceivables, in: 'XOF', locale: 'fr')">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-slot:icon>
        </x-ui.cards.trending-stat>
    </div>

    <div class="col-span-full">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">

            {{-- En-tête avec recherche --}}
            <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Créances</h3>

                <div class="relative">
                    <span class="absolute -translate-y-1/2 pointer-events-none top-1/2 left-4">
                        <svg class="fill-gray-500 size-4" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Rechercher par numéro de commande..."
                        wire:model.live.debounce.400ms="search"
                        class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black text-sm shadow-xs h-10 pl-10 pr-4 focus:outline-hidden xl:w-[300px]">
                </div>
            </div>

            {{-- Grille de cartes --}}
            <div class="px-6 pb-6">
                @if ($credits->isEmpty())
                    <div class="text-center text-gray-400 py-12">
                        Aucune créance trouvée.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach ($credits as $credit)
                            <x-ui.cards.credit-card :credit="$credit" />
                        @endforeach
                    </div>

                    @if ($credits->hasPages())
                        <div class="mt-6">
                            {{ $credits->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Composant Livewire pour l'enregistrement de paiement -->
    <livewire:dashboard.receivables.record-payment :tenant="$tenant" />
</div>