<div>
    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" enctype="multipart/form-data" novalidate>
        <div class="col-span-full">
            <label for="customer_id" class="block text-xs font-medium text-gray-600">
                {{ __('Client') }}
            </label>

            <div class="mt-1">
                <select id="customer_id" name="customer_id" wire:model.live="customer_id"
                    class="col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-1.5 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
                    <option value="">Sélectionner un client</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
                    @endforeach
                </select>
            </div>

            @error('customer_id')
                <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Emplacements -->
        <div class="col-span-full">
            <label for="warehouse_id" class="block text-xs font-medium text-gray-600">
                {{ __('Emplacement') }}
            </label>

            <div class="mt-1">
                <select id="warehouse_id" name="warehouse_id" wire:model.live="warehouse_id"
                    class="col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-1.5 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>

            @error('warehouse_id')
                <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Produits -->
        <div class="col-span-full">
            <div class="col-span-full space-y-2">
                <div class="hidden lg:grid lg:grid-cols-6 gap-x-2">
                    <span class="block text-xs text-gray-600">Produit</span>
                    <span class="block text-xs text-gray-600">Prix unitaire</span>
                    <span class="block text-xs text-gray-600">Quantité</span>
                    <span class="block text-xs text-gray-600">Total</span>
                    <span class="sr-only">Actions</span>
                </div>
            </div>

            <div class="space-y-2">
                <!-- Lignes de produits -->
                @foreach ($productLines as $index => $line)
                    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 items-center">
                        <!-- Sélecteur de produit -->
                        <div class="col-span-full">
                            <label for="product_id" class="block text-xs text-gray-600">
                                Produit
                            </label>
                            <select wire:model.live="productLines.{{ $index }}.product_id" id="product_id"
                                class="mt-1 col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-1.5 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="">Sélectionner un produit</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product?->sku ? "$product->sku  / " : '' }} {{ $product?->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error("productLines.{$index}.product_id")
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="unit_price" class="block text-xs text-gray-600">
                                Prix unitaire
                            </label>

                            <div class="mt-1 relative flex items-center">
                                <div type="text"
                                    class="block w-full text-sm rounded-md border border-gray-300 text-gray-900 placeholder:text-black focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 transition duration-150 appearance-none bg-white py-1.5 pr-14 sm:text-sm">
                                    {{ Number::currency($line['unit_price'], in: 'XOF', locale: 'fr') }}
                                </div>
                            </div>
                        </div>

                        <!-- Quantité -->
                        <div class="col-span-1">
                            <label for="quantity_product.{{ $index }}" class="block text-xs text-gray-600">
                                {{ __('Quantité') }}
                            </label>

                            <input type="number" wire:model.live="productLines.{{ $index }}.quantity"
                                min="1" max="{{ $line['available_stock'] }}"
                                class="mt-1 block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
                            @error("productLines.{$index}.quantity")
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total -->
                        <div class="col-span-1">
                            <label for="total_product_price" class="block text-xs text-gray-600">
                                {{ __('Sous total') }}
                            </label>

                            <div class="mt-1 relative flex items-center">
                                <div type="text"
                                    class="block w-full text-sm rounded-md border border-gray-300 text-gray-900 placeholder:text-black focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 transition duration-150 appearance-none bg-white py-1.5 pr-14 sm:text-sm">
                                    {{ Number::currency($line['total_price'], in: 'XOF', locale: 'fr') }}
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="col-span-1">
                            <label for="remove_product_line" class="sr-only">
                                Supprimer
                            </label>
                            @if (count($productLines) > 1)
                                <div class="mt-1 py-3 flex items-end">
                                    <button type="button" wire:click="removeProductLine({{ $index }})"
                                        class="p-1 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden bg-gray-200 text-neutral-400 hover:bg-neutral-300 focus:bg-neutral-300">
                                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 6 6 18"></path>
                                            <path d="m6 6 12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- 
                        <div class="col-span-1">
                            <label for="product_id" class="block text-xs text-gray-600">
                                Prix unitaire
                            </label>
                            <div class="mt-1 relative flex items-center">
                                <input type="text" name="search" id="search"
                                    class="block w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-black focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm transition duration-150 appearance-none bg-white py-1.5 pr-14 sm:text-sm">
                                <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                    <kbd
                                        class="inline-flex items-center rounded border border-gray-200 px-1 font-sans text-xs text-gray-400">FCFA</kbd>
                                </div>
                            </div>
                        </div>
                        --}}
                    </div>
                @endforeach
            </div>

            <!-- Bouton pour ajouter une ligne -->
            <div class="mt-4">
                <button type="button" wire:click="addProductLine"
                    class="inline-flex items-center px-3 py-1.5 border border-dashed border-gray-300 text-xs font-medium rounded-full text-black bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    + Ajouter un produit
                </button>
            </div>
        </div>

        <div class="col-span-1">
            <label for="discount" class="block text-xs text-gray-600">
                {{ __('Remise') }}
            </label>

            <input type="number" wire:model.live.number="discount"
                class="mt-1 block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
            @error('discount')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- TODO: create small input component -->
        <div class="col-span-1">
            <label for="advance" class="block text-xs text-gray-600">
                {{ __('Avance payé') }}
            </label>

            <input type="number" wire:model.live.number="advance"
                class="mt-1 block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
            @error('advance')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-span-full">
            <h3 class="block text-xs text-gray-600">
                {{ __('Statut de paiement') }}
            </h3>

            <div class="mt-1 space-y-2">
                @foreach ($paymentStatuses as $paymentStatus)
                    <div class="flex items-center">
                        <input type="radio" wire:model.live="payment_status" id="{{ $paymentStatus->value }}"
                            value="{{ $paymentStatus->value }}"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-blue-600 checked:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden">
                        <label for="{{ $paymentStatus->value }}"
                            class="ml-2 inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $paymentStatus->color() }}">
                            {{ $paymentStatus->label() }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Totaux -->
        <div class="col-span-full border-t border-gray-200 lg:px-6 py-2">
            <dl class="-my-3 divide-y divide-gray-100 px-2 py-4 text-sm/6">
                <div class="flex justify-between gap-x-4 py-2">
                    <dt class="text-sm text-gray-500">
                        {{ __('Date de commande') }}
                    </dt>
                    <dd class="text-xs font-medium text-gray-700">
                        <time datetime="{{ now()->format('Y-m-d') }}">{{ now()->format('d/m/Y') }}</time>
                    </dd>
                </div>

                <!-- Sous total -->
                <x-ui.stacked-list label="Sous total" :value="Number::currency($subtotal, in: 'XOF', locale: 'fr')" />

                <!-- Remise -->
                @if ($discount > 0)
                    <x-ui.stacked-list label="Remise" :value="Number::currency($discount, in: 'XOF', locale: 'fr')" />
                @endif

                <x-ui.stacked-list label="Montant total" :value="Number::currency($total_amount, in: 'XOF', locale: 'fr')" />

                @if ($advance > 0)
                    <x-ui.stacked-list label="Avance payée" :value="Number::currency($advance, in: 'XOF', locale: 'fr')" />

                    <x-ui.stacked-list label="Reste à payer" :value="Number::currency($total_amount - $advance, in: 'XOF', locale: 'fr')" />
                @endif
            </dl>
        </div>

        <div class="col-span-full flex justify-between gap-3 pt-2">
            <button type="button" @click="$dispatch('close-modal', { id: 'create-order' })"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
                {{ __('Annuler') }}
            </button>

            <button type="submit"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black">
                {{ __('Enregistrer') }}
            </button>
        </div>
    </form>
</div>
