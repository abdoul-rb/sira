<div>
    <x-ui.modals.create-warehouse-modal :tenant="$tenant" />

    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" enctype="multipart/form-data" novalidate>
        @if ($featured_image)
            <div class="col-span-full">
                <img src="{{ $featured_image->temporaryUrl() }}" alt="Image du produit"
                    class="size-24 lg:size-32 object-cover rounded-md">
            </div>
        @else
            <div class="col-span-full">
                <div class="relative">
                    <input type="file" accept="image/*" wire:model="featured_image" class="hidden" id="image-upload">
                    <label for="image-upload"
                        class="flex flex-col items-center justify-center w-full h-24 border border-gray-200 border-dashed rounded-xl cursor-pointer hover:border-gray-300 transition-colors">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-upload w-6 h-6 text-gray-400 mx-auto mb-2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" x2="12" y1="3" y2="15"></line>
                            </svg>
                            <span class="text-sm text-gray-500">
                                {{ __('Ajouter une photo') }}
                            </span>
                        </div>
                    </label>
                </div>

                @error($featured_image)
                    <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <x-form.input class="col-span-full" name="name" label="Nom du produit" :wire="true" :required="true" />

        <x-form.input class="col-span-1" name="price" label="Prix" type="number" :number="true"
            :required="true" />

        <!-- Quantité global du produit donc `stock_quantity` -->
        <x-form.input class="col-span-1" name="stock_quantity" label="Quantité globale" type="number" :number="true"
            :required="true" />

        <div class="col-span-full">
            <x-form.label label="Description" id="description" />

            <div class="mt-1">
                <textarea rows="4" name="description" wire:model.live="description" id="description"
                    class="block w-full rounded-md border border-gray-300 py-2 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-black text-sm sm:leading-6"></textarea>
            </div>
        </div>

        <!-- Assignation des quantités aux entrepôts -->
        <div class="col-span-full">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <h3 class="block text-sm font-medium text-gray-700">
                        {{ __('Assignation aux entrepôts') }}
                    </h3>

                    <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'create-warehouse' })">
                        {{ __('Ajouter un entrepôt') }}
                    </x-ui.btn.primary>
                </div>

                <!-- Lignes d'entrepôts -->
                @foreach ($warehouseLines as $index => $line)
                    <div class="grid grid-cols-5 gap-2 items-center">
                        <!-- Sélecteur d'entrepôt -->
                        <div class="col-span-2">
                            <x-form.label label="Entrepôt" id="warehouse-id-{{ $index }}" />
                            <select id="warehouse-id-{{ $index }}"
                                wire:model.live="warehouseLines.{{ $index }}.warehouse_id"
                                class="mt-1 block w-full rounded-md border border-gray-300 py-2 text-gray-900 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-black text-sm">
                                <option value="">{{ __('Sélectionner un entrepôt') }}</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">
                                        {{ $warehouse->name }}
                                        @if ($warehouse->default)
                                            <span class="text-xs text-gray-500">({{ __('Par défaut') }})</span>
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error("warehouseLines.{$index}.warehouse_id")
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantité -->
                        <div class="col-span-2">
                            <x-form.label label="Quantité" id="quantity-warehouse-{{ $index }}" />

                            <input type="number" id="quantity-warehouse-{{ $index }}"
                                wire:model.live.number="warehouseLines.{{ $index }}.quantity" min="0"
                                class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
                            @error("warehouseLines.{$index}.quantity")
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="col-span-1 flex items-end justify-end">
                            @if (count($warehouseLines) > 1)
                                <div class="mt-1 py-3 flex items-end">
                                    <button type="button" wire:click="removeWarehouseLine({{ $index }})"
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
                    </div>
                @endforeach
            </div>

            <!-- Bouton pour ajouter une ligne -->
            <div class="mt-4">
                <button type="button" wire:click="addWarehouseLine"
                    class="inline-flex items-center px-3 py-1.5 border border-dashed border-gray-300 text-xs font-medium rounded-full text-black bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    {{ __('+ Ajouter un entrepôt') }}
                </button>
            </div>

            <!-- Résumé des quantités -->
            <div class="mt-4 p-3 bg-gray-50 rounded-md">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">{{ __('Total assigné aux entrepôts') }}:</span>
                    <span class="font-medium">{{ $totalWarehouseQuantity }}</span>
                </div>
                <div class="flex justify-between items-center text-sm mt-1">
                    <span class="text-gray-600">{{ __('Quantité globale') }}:</span>
                    <span class="font-medium">{{ $stock_quantity ?? 0 }}</span>
                </div>

                {{-- @if ($totalWarehouseQuantity !== (int) ($stock_quantity ?? 0))
                    <div class="mt-2 text-xs text-red-600">
                        ⚠️ Les quantités ne correspondent pas
                    </div>
                @endif --}}
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="col-span-full flex justify-between gap-3 pt-2">
            <button type="button" @click="$dispatch('close-modal', { id: 'create-product' })"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100 cursor-pointer">
                {{ __('Annuler') }}
            </button>

            <x-ui.btn.primary type="submit" class="w-full" :icon="false">
                {{ __('Enregistrer') }}
            </x-ui.btn.primary>

            {{-- <button type="submit"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black cursor-pointer">
                {{ __('Enregistrer') }}
            </button> --}}
        </div>
    </form>
</div>
