<x-ui.modals.base id="edit-expense" size="xl">
    <x-slot:title>
        {{ __('Modifier le versement') }}
    </x-slot:title>

    <form wire:submit.prevent="update" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
        <x-form.input class="col-span-1" name="name" label="Nom" :wire="true" :required="true" />

        <x-form.input class="col-span-1" name="amount" label="Montant" :wire="true" :required="true" />

        <div class="col-span-1">
            <x-form.label label="Catégorie" id="category" :required="true" />

            <div class="mt-1">
                <select id="category" name="category" wire:model.live="category"
                    class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
                    @foreach ($categories as $category)
                        <option value="{{ $category->label() }}">
                            {{ $category->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            @error('category')
                <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <x-form.input type="date" class="col-span-1" name="spentAt" label="Date de dépense" :wire="true"
            :required="true" />

        <!-- Boutons d'action -->
        <div class="col-span-full flex justify-between gap-3 pt-2">
            <button type="button" @click="$dispatch('close-modal', { id: 'edit-expense' })"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
                {{ __('Annuler') }}
            </button>

            <x-ui.btn.primary class="w-full" type="submit" :icon="false">
                {{ __('Enregistrer') }}
            </x-ui.btn.primary>
        </div>
    </form>
</x-ui.modals.base>
