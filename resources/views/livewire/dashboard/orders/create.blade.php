<div>
    <x-ui.modals.create-customer-modal :tenant="$tenant" />

    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" enctype="multipart/form-data" novalidate>
        <div class="col-span-full flex items-center gap-x-2">
            <div class="flex-1">
                <label for="customer-id" class="block text-xs font-medium text-gray-600">
                    {{ __('Client') }}
                </label>

                <select id="customer-id" name="customerId" wire:model.number="customerId"
                    class="mt-1 block w-full rounded-md border border-gray-300 py-2 text-gray-900 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-black text-sm sm:leading-6">
                    <option value="">Sélectionner un client</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
                    @endforeach
                </select>

                @error('customerId')
                    <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="button" @click="$dispatch('open-modal', { id: 'add-customer' })"
                    class="mt-5 p-2 lg:p-2.5 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden bg-black text-white ring-2 ring-black cursor-pointer">
                    <span class="sr-only">Nouveau client</span>
                    <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Emplacements -->
        <div class="col-span-full">
            <x-form.label label="Emplacement" id="warehouse-id" />

            <div class="mt-1">
                <select id="warehouse-id" name="warehouseId" wire:model.live="warehouseId"
                    class="col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-1.5 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">
                            {{ $warehouse->name }} @if ($warehouse->default)
                                ({{ __('Par défaut') }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            @error('warehouseId')
                <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Produits -->
        <div class="col-span-full">
            <label for="products" class="block text-xs lg:text-sm font-medium text-gray-600">
                {{ __('Produits') }}
            </label>

            <div class="mt-2 space-y-2">
                <!-- Lignes de produits -->
                @foreach ($productLines as $index => $line)
                    <div class="grid grid-cols-6 gap-2 items-center p-3 border border-gray-200 rounded-lg">
                        <!-- Sélecteur de produit -->
                        <div class="col-span-full">
                            <div class="flex items-center justify-between">
                                <x-form.label label="Produit {{ $index + 1 }}" id="product-id" />

                                <!-- Todo: Disabled when product not selected -->
                                <button type="button" wire:click="removeProductLine({{ $index }})"
                                    class="p-1 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-hidden"
                                    @disabled(count($productLines) <= 1)>
                                    <svg class="size-5 shrink-0 text-red-600" data-slot="icon" fill="none"
                                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <select id="product-id" wire:model.live.number="productLines.{{ $index }}.product_id"
                                id="product_id"
                                class="mt-2 col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-1.5 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
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

                        <!-- Prix unitaire -->
                        <div class="col-span-2">
                            <span class="block text-xs lg:text-sm font-medium text-gray-600">Prix (PU)</span>

                            <div class="mt-1 relative flex items-center">
                                <div
                                    class="block w-full text-xs rounded-md border border-gray-300 text-gray-900 placeholder:text-black focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 transition duration-150 appearance-none bg-white py-1.5 px-2 sm:text-sm">
                                    {{ Number::currency($line['unit_price'], in: 'XOF', locale: 'fr') }}
                                </div>
                            </div>
                        </div>

                        <!-- Quantité -->
                        <div class="col-span-2">
                            <x-form.label label="Qté" id="quantity-product.{{ $index }}" />

                            <input type="number" id="quantity-product.{{ $index }}"
                                wire:model.live.number="productLines.{{ $index }}.quantity" min="1"
                                max="{{ $line['available_stock'] }}"
                                class="mt-1 block w-full rounded-md border border-gray-300 py-1 lg:py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
                            @error("productLines.{$index}.quantity")
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sous total -->
                        <div class="col-span-2">
                            <span class="block text-xs lg:text-sm font-medium text-gray-600">Sous total</span>

                            <div class="mt-1 relative flex items-center">
                                <div
                                    class="block w-full text-xs rounded-md border border-gray-300 text-gray-900 placeholder:text-black focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 transition duration-150 appearance-none bg-white py-1.5 px-2 sm:text-sm">
                                    {{ Number::currency($line['total_price'], in: 'XOF', locale: 'fr') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bouton pour ajouter une ligne -->
            <div class="mt-4">
                <button type="button" wire:click="addProductLine"
                    class="w-full inline-flex items-center justify-center px-3 py-1.5 border border-dashed border-gray-300 text-xs font-medium rounded-full text-black bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    {{ __('+ Ajouter un produit') }}
                </button>
            </div>
        </div>

        <div class="col-span-1">
            <x-form.label label="Remise" id="discount" />

            <input type="number" wire:model.live.number="discount" id="discount"
                class="mt-1 block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
            @error('discount')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- TODO: create small input component -->
        <div class="col-span-1">
            <x-form.label label="Avance payé" id="advance" />

            <input type="number" wire:model.live.number="advance" id="advance"
                class="mt-1 block w-full rounded-md border border-gray-300 py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
            @error('advance')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-span-full">
            <h3 class="block text-xs text-gray-600">
                {{ __('Mode de paiement') }}
            </h3>

            <div class="mt-2 flex gap-x-4">
                @foreach ($paymentStatuses as $status)
                    <div class="flex items-center">
                        <input type="radio" wire:model.live="paymentStatus" id="{{ $status->value }}"
                            value="{{ $status->value }}"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-blue-600 checked:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden">
                        <label for="{{ $status->value }}"
                            class="ml-1 inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $status->color() }}">
                            {{ $status->label() }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Totaux -->
        <div class="col-span-full border-t border-gray-200 py-2">
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

                <x-ui.stacked-list label="Montant total" :value="Number::currency($totalAmount, in: 'XOF', locale: 'fr')" />

                @if ($advance > 0)
                    <x-ui.stacked-list label="Avance payée" :value="Number::currency($advance, in: 'XOF', locale: 'fr')" />

                    <x-ui.stacked-list label="Reste à payer" :value="Number::currency($totalAmount - $advance, in: 'XOF', locale: 'fr')" />
                @endif
            </dl>
        </div>

        <div class="col-span-full flex justify-between gap-3 pt-2">
            <button type="button" @click="$dispatch('close-modal', { id: 'create-order' })"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
                {{ __('Annuler') }}
            </button>

            <x-ui.btn.primary class="w-full" type="submit" :icon="false">
                {{ __('Enregistrer') }}
            </x-ui.btn.primary>
        </div>
    </form>
</div>