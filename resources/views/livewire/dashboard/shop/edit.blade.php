<form wire:submit.prevent="save" class="space-y-6" enctype="multipart/form-data" novalidate>

    <!-- Informations générales -->
    <div class="grid grid-cols-1 gap-3">
        <x-form.input name="name" label="Nom de la boutique" type="text" :wire="true" :required="true" />
    </div>

    <!-- Réseaux sociaux -->
    <div class="space-y-3">
        <h3 class="text-lg font-medium text-gray-900">{{ __('Réseaux sociaux') }}</h3>

        <div class="grid grid-cols-1 gap-4">
            <x-form.input name="facebookUrl" label="URL Facebook" type="url" :wire="true"
                placeholder="https://facebook.com/votre-page" />

            <x-form.input name="instagramUrl" label="URL Instagram" type="url" :wire="true"
                placeholder="https://instagram.com/votre-compte" />

            <x-form.input name="tiktokUrl" label="URL TikTok" type="url" :wire="true"
                placeholder="https://tiktok.com/@votre-compte" />
        </div>
    </div>

    <!-- Statut -->
    {{-- <div class="flex items-center">
        <input type="checkbox" wire:model="active" id="active" name="active"
            class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
        <label for="active" class="ml-2 block text-sm text-gray-900">
            {{ __('Boutique active') }}
        </label>
    </div> --}}

    <!-- Boutons d'action -->
    <div class="flex justify-between gap-3 pt-4">
        <button type="button" @click="$dispatch('close-modal', { id: 'edit-shop' })"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100 cursor-pointer">
            {{ __('Annuler') }}
        </button>

        <button type="submit"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black hover:bg-gray-800 cursor-pointer"
            wire:loading.attr="disabled" wire:target="save">
            <span wire:loading wire:target="save">
                <svg class="animate-spin h-5 w-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </span>
            {{ __('Mettre à jour') }}
        </button>
    </div>
</form>