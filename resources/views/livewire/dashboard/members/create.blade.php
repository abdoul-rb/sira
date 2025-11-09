<form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-2 gap-x-3 gap-y-4">
    <x-form.input name="firstname" label="Prénom" :wire="true" :required="true" />

    <x-form.input name="lastname" label="Nom" :wire="true" :required="true" />

    <x-form.input name="phoneNumber" label="Numéro de téléphone" :wire="true" :required="true" />

    <x-form.input class="col-span-full" type="email" name="email" label="Email" :wire="true"
        :required="true" />

    <div class="col-span-full space-y-4">
        <div class="flex items-center gap-x-2">
            <button type="button" wire:click="$toggle('canLogin')"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 {{ $canLogin ? 'bg-teal-600' : 'bg-gray-200' }}"
                role="switch" aria-checked="{{ $canLogin ? 'true' : 'false' }}">
                <span
                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition-all duration-200 ease-in-out {{ $canLogin ? 'translate-x-5' : 'translate-x-0' }}">
                </span>
            </button>
            <span class="block text-sm text-gray-600">Cet employé peut se connecter</span>
        </div>

        @if ($canLogin)
            <div class="flex items-end gap-x-2">
                <x-form.input-password class="flex-1" name="password" :label="__('Mot de passe')" :wire="true" />

                <div class="relative" x-data="{ copied: false }">
                    <template x-if="copied"
                        class="absolute inset-x-0 bottom-full mb-2.5 flex justify-center transition ease-in duration-100">
                        <div
                            class="rounded-full border border-gray-950 bg-gray-950 px-2 text-xs/6 font-medium tracking-wide text-white inset-ring inset-ring-white/10">
                            Copié
                        </div>
                    </template>

                    <button type="button"
                        @click="navigator.clipboard.writeText('{{ $password }}'); copied = true; setTimeout(() => copied = false, 3000);"
                        class="group inline-flex items-center justify-center rounded-md bg-white border border-gray-300 p-2.5 text-sm text-black cursor-pointer">
                        <svg class="w-4 h-4 shrink-0 group-hover:stroke-gray-950 transition duration-150"
                            :class="{ 'rotate-[-8deg]': copied }" data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <x-form.label label="Rôle" id="role" :required="true" />
                <div class="mt-1">
                    <select wire:model="role" id="role" required
                        class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm">
                        <option value="">Sélectionner un rôle</option>
                        <option value="{{ App\Enums\RoleEnum::OPERATOR }}">
                            {{ App\Enums\RoleEnum::OPERATOR->label() }}
                        </option>
                    </select>
                </div>
                @error('role')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- <div class="flex">
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
            </div> --}}
        @endif
    </div>

    <div class="col-span-full flex justify-between gap-3 mt-4">
        <button type="button" @click="$dispatch('close-modal', { id: 'create-member' })"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100 cursor-pointer">
            {{ __('Annuler') }}
        </button>

        <button type="submit"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black cursor-pointer">
            {{ __('Enregistrer') }}
        </button>
    </div>
</form>
