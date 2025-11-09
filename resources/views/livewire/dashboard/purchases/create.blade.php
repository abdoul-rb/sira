<x-ui.modals.base id="add-purchase" size="xl">
    <x-slot:title>
        {{ __('Enregistrer un achat') }}
    </x-slot:title>

    <div>
        <x-ui.modals.create-supplier-modal :tenant="$tenant" />

        <form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
            <div class="col-span-full flex items-center gap-x-2">
                <div class="flex-1">
                    <label for="supplier-id" class="block text-sm font-medium text-gray-700">
                        {{ __('Fournisseur') }}
                        <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="supplierId" id="supplier-id" name="supplier_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 text-gray-900 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-black text-sm sm:leading-6">
                        <option value="">{{ __('Sélectionner un fournisseur') }}</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplierId')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="button" @click="$dispatch('open-modal', { id: 'create-supplier' })"
                        class="mt-6 p-2.5 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden bg-black text-white ring-2 ring-black cursor-pointer">
                        <span class="sr-only">Créer un nouveau fournisseur</span>
                        <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <x-form.input class="col-span-1" name="amount" label="Montant" :wire="true" :required="true" />

            <x-form.input type="date" class="col-span-1" name="purchasedAt" label="Date d'achat" :wire="true"
                :required="true" />

            <div class="col-span-full">
                <x-form.label label="Détails" id="details" />
                <div class="mt-1">
                    <textarea rows="4" name="details" wire:model.live="details" id="details"
                        class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm bg-white"></textarea>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="col-span-full flex justify-between gap-3 pt-2">
                <button type="button" @click="$dispatch('close-modal', { id: 'add-purchase' })"
                    class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100 cursor-pointer">
                    {{ __('Annuler') }}
                </button>

                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black cursor-pointer">
                    {{ __('Enregistrer') }}
                </button>
            </div>
        </form>
    </div>
</x-ui.modals.base>
