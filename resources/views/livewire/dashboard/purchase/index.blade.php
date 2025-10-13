@section('title', __('Liste des achats'))

<div>
    <div class="flex items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Les achats') }}
        </h1>

        <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'add-purchase' })">
            {{ __('Ajouter un achat') }}
        </x-ui.btn.primary>
    </div>

    <x-ui.modals.add-purchase-modal :tenant="$tenant" />

    <div class="mt-3 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="w-full md:w-1/2">
                <!-- Recherche globale -->
                <div class="relative">
                    <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
                        <svg class="fill-gray-500 " width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                                fill=""></path>
                        </svg>
                    </span>
                    <input type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Rechercher par nom, email..."
                        class="shadow-xs focus:border-brand-300 focus:ring-gray-500/10 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-1 focus:outline-hidden xl:w-[430px]">
                </div>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-md px-4 py-2">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-lg border text-gray-500 relative overflow-hidden border-gray-200 bg-white">
                <div class="relative p-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-xl bg-gradient-to-r from-blue-100 via-blue-300 to-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="size-6 text-white shrink-0">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path
                                    d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Achats</p>
                            <p class="text-2xl font-bold text-gray-500">{{ $purchases->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-lg border text-gray-500 relative overflow-hidden border-gray-200 bg-white">
                <div class="relative p-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-xl bg-gradient-to-r from-sky-400 to-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="size-6 text-white shrink-0">
                                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                <polyline points="16 7 22 7 22 13"></polyline>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Montant Total</p>
                            <p class="text-lg font-semibold text-gray-500">
                                {{ Number::currency($totalAmount, in: 'XOF', locale: 'fr') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-lg border text-gray-500 relative overflow-hidden border-gray-200 bg-white">
                <div class="relative p-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-xl bg-gradient-to-r from-sky-400 to-cyan-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="size-6 text-white shrink-0">
                                <path
                                    d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z">
                                </path>
                                <path d="M12 22V12"></path>
                                <path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path>
                                <path d="m7.5 4.27 9 5.15"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Montant Moyen</p>
                            <p class="text-lg font-semibold text-gray-500">
                                {{ Number::currency($averageAmount, in: 'XOF', locale: 'fr') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
            @forelse($purchases as $purchase)
                <x-ui.cards.purchase-details :purchase="$purchase" />
            @empty
                <div class="col-span-full text-center text-gray-500 py-10">Aucun achat trouvé.</div>
            @endforelse
        </ul>

        <div class="mt-6">
            {{ $purchases->links() }}
        </div>
    </div>
</div>
