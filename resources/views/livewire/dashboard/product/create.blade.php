<div>
    <x-ui.breadcrumb :items="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard.index', ['tenant' => $tenant])],
        ['label' => 'Produits', 'url' => route('dashboard.products.index', ['tenant' => $tenant])],
        ['label' => 'Créer', 'url' => '#'],
    ]" />

    <h1 class="text-2xl font-bold text-gray-800 mt-6 mb-8">Créer un produit</h1>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-md px-4 py-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne principale (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
                <header class="flex flex-col gap-3 px-6 py-4">
                    <h3 class="text-base font-medium leading-6 text-gray-950">
                        Général
                    </h3>
                </header>

                <div class="border-t border-gray-200 px-4 py-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-6">
                    <x-form.input class="col-span-full" name="name" label="Nom du produit" :wire="true" />

                    <div class="col-span-full">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            {{ __('Description') }}
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2">
                            <textarea rows="4" name="description" wire:model.live="description" id="description"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
                <header class="flex flex-col gap-3 px-6 py-4">
                    <h3 class="text-base font-medium leading-6 text-gray-950">
                        {{ __('Inventaire') }}
                    </h3>
                </header>

                <div class="border-t border-gray-200 px-4 py-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-6">
                    <x-form.input name="stock_quantity" label="Stock" :wire="true" type="number" />
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
                <header class="flex flex-col gap-3 px-6 py-4">
                    <h3 class="text-base font-medium leading-6 text-gray-950">
                        {{ __('Prix & stock') }}
                    </h3>
                </header>

                <div class="border-t border-gray-200 px-4 py-6 sm:p-8 grid grid-cols-1 gap-y-6">
                    <x-form.input name="price" label="Prix (€)" :wire="true" type="number" step="0.01" />

                    <x-form.input name="sku" label="SKU" :wire="true" />
                </div>
            </div>
        </div>

        <!-- Bouton de sauvegarde -->
        <div class="md:col-span-full">
            <button type="submit"
                class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-blue-600 px-3 py-2 text-sm text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                {{ __('Enregistrer') }}
            </button>
        </div>
    </form>
</div>
