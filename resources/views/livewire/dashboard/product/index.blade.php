<div class="space-y-6" x-data="{
    init() {
        Livewire.on('product-created', () => {
            // Rafraîchir la liste des produits
            $wire.$refresh()
        })
    },
}">
    <div class="mt-6 flex items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Mes produits') }}
        </h1>

        <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'create-product' })">
            {{ __('Ajouter un produit') }}
        </x-ui.btn.primary>
    </div>

    <!-- Recherche globale -->
    <div class="relative">
        <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
            <svg class="fill-gray-500" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                    fill=""></path>
            </svg>
        </span>
        <input type="text" wire:model.debounce.400ms="search" placeholder="Rechercher un produit ..."
            class="shadow-xs focus:border-brand-300 focus:ring-gray-500/10 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-1 focus:outline-hidden xl:w-[430px]">
    </div>

    <!-- Modal de création de produit -->
    <x-ui.modals.create-product-modal :tenant="$tenant" />

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-md px-4 py-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="mx-auto max-w-2xl sm:max-w-none px-0 py-6 lg:max-w-7xl">
        <h2 class="sr-only">Products</h2>

        <div class="grid grid-cols-1 gap-x-3 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <x-ui.cards.product-card :product="$product" />
            @empty
                <div class="text-center text-gray-400 py-8">
                    Aucun produit trouvé.
                </div>
            @endforelse
        </div>
    </div>
</div>
