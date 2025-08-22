<div class="space-y-6">
    <div class="w-20 h-20 mx-auto rounded-full bg-black flex items-center justify-center elegant-shadow">
        <span class="text-2xl font-bold text-white">M</span>
    </div>

    <div class="flex justify-center gap-4">
        <a href="#" target="_self" rel="noopener noreferrer"
            class="p-3 rounded-full border border-gray-200 hover:border-black transition-all duration-300 hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-instagram w-5 h-5 text-gray-600 hover:text-black">
                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
            </svg>
        </a>
        <a href="#" target="_self" rel="noopener noreferrer"
            class="p-3 rounded-full border border-gray-200 hover:border-black transition-all duration-300 hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-facebook w-5 h-5 text-gray-600 hover:text-black">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
            </svg>
        </a>
    </div>

    <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Liste des produits') }}
        </h1>

        <a href="{{ tenant_route('dashboard.products.create') }}"
            class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
            <svg class="size-4 transition duration-75 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
            </svg>
            {{ __('Ajouter un produit') }}
        </a>
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
        <input type="text" wire:model.debounce.400ms="search" placeholder="Recherche produit..."
            class="shadow-xs focus:border-brand-300 focus:ring-gray-500/10 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-1 focus:outline-hidden xl:w-[430px]">
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-md px-4 py-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- <div class="overflow-x-auto bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-lg mt-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <x-ui.tables.row class="bg-gray-50">
                    <x-ui.tables.heading sortable direction="asc"
                        wire:click.prevent="sortBy('created_at', '{{ $sortDirection === 'asc' ? 'desc' : 'asc' }}')">
                        <span class="block font-medium text-gray-500 text-xs uppercase">
                            {{ __('Nom') }}
                        </span>
                    </x-ui.tables.heading>

                    <x-ui.tables.heading>
                        <span class="block font-medium text-gray-500 text-xs uppercase">
                            {{ __('SKU') }}
                        </span>
                    </x-ui.tables.heading>

                    <x-ui.tables.heading sortable direction="asc"
                        wire:click.prevent="sortBy('price', '{{ $sortDirection === 'asc' ? 'desc' : 'asc' }}')">
                        <span class="block font-medium text-gray-500 text-xs uppercase">
                            {{ __('Prix') }}
                        </span>
                    </x-ui.tables.heading>

                    <x-ui.tables.heading>
                        <span class="block font-medium text-gray-500 text-xs uppercase">
                            {{ __('Stock') }}
                        </span>
                    </x-ui.tables.heading>

                    <x-ui.tables.heading>
                        <span class="block font-medium text-gray-500 text-xs uppercase">
                            {{ __('Actions') }}
                        </span>
                    </x-ui.tables.heading>
                </x-ui.tables.row>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                    <x-ui.tables.row class="hover:bg-gray-50 transition-colors">
                        <x-ui.tables.cell>
                            <span class="text-gray-700 text-sm">
                                {{ $product->name }}
                            </span>
                        </x-ui.tables.cell>

                        <x-ui.tables.cell>
                            <span class="text-gray-700 text-sm">
                                {{ $product->sku }}
                            </span>
                        </x-ui.tables.cell>

                        <x-ui.tables.cell>
                            <span class="text-gray-700 text-sm">
                                <!-- Number::currency($product->price, in: 'EUR', locale: 'fr') -->
                                {{ number_format($product->price, 2, ',', ' ') }} €
                            </span>
                        </x-ui.tables.cell>

                        <x-ui.tables.cell>
                            <span class="text-gray-700 text-sm">
                                {{ $product->stock_quantity }}
                            </span>
                        </x-ui.tables.cell>

                        <x-ui.tables.cell>
                            <div class="flex items-center justify-end gap-x-2">
                                <a href="{{ tenant_route('dashboard.products.edit', ['product' => $product]) }}"
                                    class="inline-flex items-center justify-center text-blue-600 text-sm rounded-md p-2 hover:bg-gray-200 hover:text-blue-700">
                                    <span class="sr-only">{{ __('Éditer') }}</span>
                                    <svg class="size-4 text-blue-500 shrink-0" data-slot="icon" fill="none"
                                        stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                        </path>
                                    </svg>
                                </a>

                                <div class="flex items-center">
                                    <button wire:click="confirmDelete({{ $product->id }})"
                                        class="inline-flex items-center justify-center text-red-600 text-sm rounded-md p-2 hover:bg-gray-200 hover:text-red-700 cursor-pointer">
                                        <span class="sr-only">{{ __('Supprimer') }}</span>
                                        <svg class="size-4 text-red-500 shrink-0" data-slot="icon" fill="none"
                                            stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                            </path>
                                        </svg>
                                    </button>

                                    @if ($confirmingDelete === $product->id)
                                        <div
                                            class="absolute inset-0 bg-white/80 flex flex-col items-center justify-center z-10 rounded-lg">
                                            <div class="mb-2 text-gray-700">
                                                {{ __('Confirmer la suppression ?') }}
                                            </div>
                                            <div class="flex gap-2">
                                                <button wire:click="deleteProduct({{ $product->id }})"
                                                    class="px-3 py-1 bg-red-600 text-white rounded">
                                                    Oui
                                                </button>
                                                <button wire:click="$set('confirmingDelete', null)"
                                                    class="px-3 py-1 bg-gray-200 rounded">
                                                    Non
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </x-ui.tables.cell>
                    </x-ui.tables.row>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-10">Aucun produit trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> --}}

    {{-- <div class="mt-6">
        {{ $products->links() }}
    </div> --}}

    <div class="mx-auto max-w-2xl px-0 py-6 sm:px-6 lg:max-w-7xl lg:px-4">
        <h2 class="sr-only">Products</h2>

        <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
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
