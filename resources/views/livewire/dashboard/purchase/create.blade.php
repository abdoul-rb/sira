<form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
    <div class="col-span-full">
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
