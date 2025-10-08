<form wire:submit="save" class="">
    <div class="space-y-6">
        <!-- Informations générales -->
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 rounded-lg">
            <header class="flex flex-col gap-3 px-4 py-2">
                <h3 class="text-sm font-medium leading-6 text-black">
                    Informations générales
                </h3>
            </header>

            <div class="border-t border-gray-200 p-4 grid grid-cols-1 lg:grid-cols-2 gap-x-3 gap-y-6">
                <x-form.input name="firstname" label="Prénom" :wire="true" :required="true" />

                <x-form.input name="lastname" label="Nom" :wire="true" :required="true" />

                <x-form.input name="phoneNumber" label="Numéro de téléphone" :wire="true" :required="true" />
            </div>
        </div>

        <!-- Accès utilisateur -->
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 rounded-lg">
            <header class="flex flex-col gap-3 px-4 py-2">
                <h3 class="text-sm font-medium leading-6 text-black">
                    Accès utilisateur
                </h3>
            </header>

            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-medium text-black">Peut se connecter</h4>

                    <div class="flex items-center">
                        <button type="button" wire:click="$toggle('canLogin')"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 {{ $canLogin ? 'bg-teal-600' : 'bg-gray-200' }}"
                            role="switch" aria-checked="{{ $canLogin ? 'true' : 'false' }}">
                            <span class="sr-only">Peut se connecter</span>
                            <span
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition-all duration-200 ease-in-out {{ $canLogin ? 'translate-x-5' : 'translate-x-0' }}">
                            </span>
                        </button>
                    </div>
                </div>

                @if ($canLogin)
                    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <x-form.input type="email" name="email" label="Email" :wire="true" />

                        <x-form.input type="email" name="password" label="Mot de passe" :wire="true" />

                        <div class="lg:col-span-full rounded-md bg-blue-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">
                                        Invitation automatique
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>
                                            Un email d'invitation sera automatiquement envoyé à l'adresse indiquée
                                            pour permettre à l'employé de définir son mot de passe.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="flex justify-between gap-3 mt-4">
        <button type="button" @click="$dispatch('close-modal', { id: 'create-member' })"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
            {{ __('Annuler') }}
        </button>

        <button type="submit"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black">
            {{ __('Enregistrer') }}
        </button>
    </div>
</form>
