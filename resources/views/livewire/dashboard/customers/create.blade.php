<form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
    <x-form.input class="col-span-1" name="firstname" label="Prénom" :wire="true" :required="true" />
    <x-form.input class="col-span-1" name="lastname" label="Nom" :wire="true" :required="true" />

    <x-form.input class="col-span-full" name="email" label="Email" :wire="true" type="email" />
    <x-form.input class="col-span-full" name="phone_number" label="Téléphone" :wire="true" :required="true" />

    <x-form.input class="col-span-full" name="address" label="Localisation" :wire="true" />

    <!-- Boutons d'action -->
    <div class="col-span-full flex justify-between gap-3 pt-2">
        <button type="button" @click="$dispatch('close-modal', { id: 'add-customer' })"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
            {{ __('Annuler') }}
        </button>

        <x-ui.btn.primary class="w-full" type="submit" :icon="false">
            {{ __('Enregistrer') }}
        </x-ui.btn.primary>
    </div>
</form>
