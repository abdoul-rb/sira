<div>
    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
        <x-form.input class="col-span-full" name="name" label="Nom" :wire="true" :required="true" />

        <x-form.input class="col-span-1" name="email" label="Adresse email" :wire="true" />
        <x-form.input class="col-span-1" name="phoneNumber" label="Numéro de téléphone" :wire="true" />

        <!-- TODO: Ajouter toggle fournisseur principale -->

        <!-- Boutons d'action -->
        <div class="col-span-full flex justify-between gap-3 pt-2">
            <button type="button" @click="$dispatch('close-modal', { id: 'create-supplier' })"
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
