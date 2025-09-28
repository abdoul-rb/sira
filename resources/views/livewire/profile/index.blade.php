@section('title', __('Mon profil'))

<div class="mx-auto max-w-7xl">
    <div class="divide-y divide-gray-900/10">
        <div class="grid grid-cols-1 gap-6 py-4 md:grid-cols-3">
            <div class="">
                <h2 class="text-base font-medium text-black">
                    Informations sur le profil
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Mettez à jour les informations de profil et l'adresse e-mail de votre compte.
                </p>
            </div>

            <form class="bg-white shadow-xs outline outline-gray-900/5 rounded-md sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-3 gap-y-5 lg:grid-cols-6">
                        <div class="col-span-full">
                            <label for="photo" class="block text-sm/6 font-medium text-gray-900">
                                Photo de profil
                            </label>
                            <div class="mt-2 flex items-center gap-x-3">
                                <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true"
                                    class="size-16 text-gray-300">
                                    <path
                                        d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                                <input type="file" name="photo" id="photo" class="hidden">
                                <button type="button"
                                    class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50">Changer</button>
                            </div>
                        </div>

                        <x-form.input class="lg:col-span-3" type="text" name="firstname" label="Prénom"
                            :wire="true" />

                        <x-form.input class="lg:col-span-3" type="text" name="lastname" label="Nom"
                            :wire="true" />

                        <x-form.input class="lg:col-span-4" type="text" name="phone_number"
                            label="Numéro de téléphone" :wire="true" />

                        <x-form.input class="lg:col-span-full" type="text" name="email" label="Email"
                            :wire="true" />
                    </div>
                </div>
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
                    <x-ui.btn.primary type="submit" :icon="false">
                        {{ __('Enregistrer') }}
                    </x-ui.btn.primary>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-6 py-4 md:grid-cols-3">
            <div>
                <h2 class="text-base/7 font-semibold text-gray-900">
                    Mot de passe
                </h2>
                <p class="mt-1 text-sm/6 text-gray-600">
                    Mettez à jour votre mot de passe.
                </p>
            </div>

            <form class="bg-white shadow-xs outline outline-gray-900/5 rounded-md sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-3 gap-y-5 lg:grid-cols-6">
                        <x-form.input class="lg:col-span-full" type="password" name="current_password"
                            label="Mot de passe actuel" :wire="true" />

                        <x-form.input class="lg:col-span-full" type="password" name="password"
                            label="Nouveau mot de passe" :wire="true" />

                        <x-form.input class="lg:col-span-full" type="password" name="password_confirmation"
                            label="Confirmer le nouveau mot de passe" :wire="true" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
                    <x-ui.btn.primary type="submit" :icon="false">
                        {{ __('Enregistrer') }}
                    </x-ui.btn.primary>
                </div>
            </form>
        </div>
    </div>
</div>
