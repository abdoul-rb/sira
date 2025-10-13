<div>
    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
        <x-form.input class="col-span-1" name="reference" label="Référence" :wire="true" :required="true" />

        <x-form.input class="col-span-1" name="label" label="Libellé" :wire="true" :required="true" />

        <x-form.input class="col-span-1" name="amount" label="Montant" :wire="true" :required="true" />

        <x-form.input type="date" class="col-span-1" name="depositedAt" label="Date de dépôt" :wire="true"
            :required="true" />

        <div class="col-span-full">
            <x-form.label label="Banque" id="bank" :required="true" />

            <div class="mt-1">
                <select id="bank" name="bank" wire:model.live="bank"
                    class="col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-1.5 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach (['BNG', 'UBA', 'Ecobank', 'SGBG', 'BSIC', 'Autre'] as $bank)
                        <option value="{{ $bank }}">
                            {{ $bank }}
                        </option>
                    @endforeach
                </select>
            </div>

            @error('bank')
                <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <!-- Boutons d'action -->
        <div class="col-span-full flex justify-between gap-3 pt-2">
            <button type="button" @click="$dispatch('close-modal', { id: 'create-deposit' })"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
                {{ __('Annuler') }}
            </button>

            <button type="submit"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black cursor-pointer">
                {{ __('Enregistrer') }}
            </button>
        </div>
    </form>
</div>
