<x-ui.modals.base id="edit-customer" size="xl">
    <x-slot:title>
        {{ __('Modifier le client') }}
    </x-slot:title>

    <form wire:submit.prevent="update" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
        <x-form.input class="col-span-1" name="firstname" label="Prénom" :wire="true" :required="true" />
        <x-form.input class="col-span-1" name="lastname" label="Nom" :wire="true" :required="true" />

        <x-form.input class="col-span-full" name="email" label="Email" :wire="true" type="email" />
        <x-form.input class="col-span-full" name="phoneNumber" label="Téléphone" :wire="true" :required="true" />

        <x-form.input class="col-span-full" name="address" label="Localisation" :wire="true" />

        <!-- Boutons d'action -->
        <div class="col-span-full flex justify-between gap-3 pt-2">
            <button type="button" @click="$dispatch('close-modal', { id: 'edit-customer' })"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
                {{ __('Annuler') }}
            </button>

            <x-ui.btn.primary class="w-full" type="submit" :icon="false">
                {{ __('Enregistrer') }}
            </x-ui.btn.primary>
        </div>
    </form>

    {{-- <div>
        <label for="type" class="block text-sm font-medium text-gray-700">
            Type de client
        </label>
        <select wire:model.live="type" name="type" id="type"
            class="mt-1 w-full rounded-md border-gray-300 text-sm focus:ring-teal-600">
            @foreach ($types as $enum)
                <option value="{{ $enum->value }}" @selected($type == $enum->value)>
                    {{ $enum->label() }}
                </option>
            @endforeach
        </select>
    </div> --}}
</x-ui.modals.base>
