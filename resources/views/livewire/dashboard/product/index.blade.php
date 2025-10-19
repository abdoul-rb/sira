@section('title', 'Gestion du stock produits')

<div class="space-y-6" x-data="{
    viewType: 'card',
    init() {
        Livewire.on('product-created', () => {
            // Rafraîchir la liste des produits
            $wire.$refresh()
        })
    },
}">
    <div class="flex items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Mes produits') }}
        </h1>

        <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'create-product' })">
            {{ __('Ajouter un produit') }}
        </x-ui.btn.primary>
    </div>

    <p class="-mt-2 text-sm text-gray-500">
        {{ __('Consultez et gérez vos stocks de produits ici. Vous pouvez ajouter, modifier et supprimer des produits.') }}
    </p>

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

    <div class="mx-auto max-w-2xl sm:max-w-none lg:max-w-7xl">
        <h2 class="sr-only">Products</h2>

        <div class="flex justify-end">
            <div
                class="relative inline-flex items-center justify-center w-full max-w-44 py-2 px-4 grid-cols-2 gap-x-6 bg-gray-100 border border-gray-200 rounded-lg select-none">
                <button type="button"
                    class="z-20 inline-flex items-center justify-center w-full py-1.5 px-2 transition-all rounded-md cursor-pointer whitespace-nowrap"
                    :class="{ 'text-black': viewType === 'card', 'text-slate-900': viewType !== 'card' }"
                    @click="viewType = 'card'">

                    <span class="sr-only">En carte</span>

                    <svg class="size-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z" />
                    </svg>
                </button>

                <button type="button"
                    class="z-20 inline-flex items-center justify-center w-full py-1.5 px-2 transition-all rounded-md cursor-pointer whitespace-nowrap"
                    :class="{ 'text-black': viewType === 'table', 'text-slate-900': viewType !== 'table' }"
                    @click="viewType = 'table'">

                    <span class="sr-only">Tableau</span>
                    <svg class="size-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                    </svg>
                </button>

                <div class="absolute left-0 z-10 w-1/2 h-full duration-300 ease-out py-1 px-1 transition-all"
                    :class="viewType === 'card' ? 'left-0' : 'left-1/2'">
                    <div class="w-full h-full bg-white z-0 rounded-lg shadow-sm flex items-center justify-center"></div>
                </div>
            </div>
        </div>

        <div class="mt-5 grid grid-cols-1 gap-x-3 gap-y-4 sm:grid-cols-2 lg:grid-cols-3"
            x-show.transition.in.opacity.duration.600="viewType === 'card'">
            @forelse ($products as $product)
                <x-ui.cards.product-card :product="$product" />
            @empty
                <div class="text-center text-gray-400 py-8">
                    Aucun produit trouvé.
                </div>
            @endforelse
        </div>

        <div class="mt-5" x-show.transition.in.opacity.duration.600="viewType === 'table'">
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-sm outline-1 outline-black/5 sm:rounded-lg">
                            <table class="relative min-w-full divide-y divide-gray-300">
                                <thead class="border-gray-100 border-y bg-gray-100">
                                    <x-ui.tables.row>
                                        <x-ui.tables.heading class="w-96">
                                            <div class="font-medium text-gray-500 text-xs">
                                                {{ __('Produit') }}
                                            </div>
                                        </x-ui.tables.heading>

                                        <x-ui.tables.heading class="w-40">
                                            <span class="font-medium text-gray-500 text-xs">
                                                {{ __('SKU') }}
                                            </span>
                                        </x-ui.tables.heading>

                                        <x-ui.tables.heading class="min-w-40">
                                            <span class="font-medium text-gray-500 text-xs">
                                                {{ __('Prix') }}
                                            </span>
                                        </x-ui.tables.heading>

                                        <x-ui.tables.heading>
                                            <span class="font-medium text-gray-500 text-xs">
                                                {{ __('Quantité') }}
                                            </span>
                                        </x-ui.tables.heading>

                                        <x-ui.tables.heading class=" flex items-center justify-end">
                                            <span class="font-medium text-gray-500 text-xs">
                                                Action
                                            </span>
                                        </x-ui.tables.heading>
                                    </x-ui.tables.row>
                                </thead>

                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse($products as $product)
                                        <x-ui.tables.row class="hover:bg-gray-50">
                                            <x-ui.tables.cell class="flex items-center gap-2">
                                                @if ($product->featured_image)
                                                    <img src="{{ Storage::disk('public')->url($product->featured_image) }}"
                                                        alt="{{ $product->name }}"
                                                        class="size-12 object-cover rounded-md" />
                                                @endif

                                                <span class="text-gray-700 text-sm">
                                                    {{ $product->name }}
                                                </span>
                                            </x-ui.tables.cell>

                                            <x-ui.tables.cell>
                                                <span class="text-gray-700 text-sm">
                                                    {{ $product->sku ?? '' }}
                                                </span>
                                            </x-ui.tables.cell>

                                            <x-ui.tables.cell>
                                                <span class="text-gray-700 text-sm">
                                                    {{ Number::currency($product->price, in: 'XOF', locale: 'fr') }}
                                                </span>
                                            </x-ui.tables.cell>

                                            <x-ui.tables.cell>
                                                <span class="text-gray-700 text-sm">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            </x-ui.tables.cell>

                                            <x-ui.tables.cell>
                                                <div class="flex items-center gap-2">
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button @click="open = !open"
                                                            class="flex items-center rounded-full text-gray-400 hover:text-gray-600"
                                                            type="button" aria-haspopup="menu" :aria-expanded="open">
                                                            <span class="sr-only">Options</span>
                                                            <svg viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                                                <path
                                                                    d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                                                            </svg>
                                                        </button>

                                                        <!-- Menu dropdown -->
                                                        <div x-show="open" @click.outside="open = false"
                                                            class="absolute right-0 mt-2 w-56 rounded-md bg-white shadow-lg outline-1 outline-black/5 z-40"
                                                            role="menu">
                                                            <div class="py-1">
                                                                <a href="#"
                                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                    role="menuitem">
                                                                    Account settings
                                                                </a>
                                                                <a href="#"
                                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                    role="menuitem">
                                                                    Support
                                                                </a>
                                                                <a href="#"
                                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                    role="menuitem">
                                                                    License
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </x-ui.tables.cell>
                                        </x-ui.tables.row>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-gray-400 py-8">
                                                Aucun produit trouvé.
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
</div>
