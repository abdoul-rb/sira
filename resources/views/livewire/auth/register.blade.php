@section('title', __('Créer un compte'))

<div class="flex min-h-screen bg-white">
    <div
        class="w-1/2 flex flex-1 flex-col justify-center px-5 py-12 sm:px-6 lg:flex-none lg:px-12 overflow-y-scroll min-h-screen">
        <div class="mx-auto w-full">
            <div class="">
                <a href="{{ route('home') }}" class="">
                    <img class="h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                        alt="Your Company">
                </a>

                <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">
                    {{ __('Créer un compte') }}
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    {{ __('Déjà un compte ? ') }}
                    <a href="{{ route('auth.login') }}" class="font-medium text-sky-600">
                        {{ __('Connectez-vous ici') }}
                    </a>
                </p>
            </div>

            <div class="mt-10">
                <form wire:submit.prevent="register" method="POST" class="mt-10 grid grid-cols-2 gap-x-2 gap-y-4">
                    <x-form.input type="text" name="firstname" label="Prénom" :wire="true" />

                    <x-form.input type="text" name="lastname" label="Nom" :wire="true" />

                    <x-form.input class="col-span-full" type="text" name="companyName" label="Nom de l'entreprise"
                        :wire="true" />

                    <x-form.input class="col-span-full" type="text" name="phoneNumber" label="Téléphone"
                        :wire="true" />

                    <x-form.input class="col-span-full" type="email" name="email" label="Adresse email"
                        :wire="true" />

                    <x-form.input-password class="col-span-full" name="password" label="Mot de passe"
                        :wire="true" />

                    <div class="col-span-full flex items-center">
                        <input wire:model.lazy="terms" id="terms" type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-sky-600 focus:ring-sky-600">
                        <label for="terms" class="ml-2 block text-sm leading-6 text-gray-700">
                            {{ __("J'accepte les conditions générales d'utilisation") }}
                        </label>
                    </div>

                    <div class="col-span-full">
                        <button type="submit"
                            class="flexflex w-full justify-center rounded-md bg-gray-900 px-3 py-1.5 text-sm font-medium leading-6 text-white shadow-sm focus-visible:outline-offset-2 focus-visible:outline-black cursor-pointer">
                            {{ __('Créer mon compte') }}
                        </button>
                    </div>
                </form>

                <!-- Social login Waly -->
            </div>
        </div>
    </div>

    <!-- Right column container with background and description-->
    <div
        class="w-1/2 fixed right-0 top-0 h-screen hidden md:flex md:items-center bg-gradient-to-tr from-sky-100 via-rose-50 to-teal-100">
        <div class="px-4 py-6 text-white md:mx-6 md:p-8 space-y-4">

            <div
                class="group bg-slate-50 rounded-lg border border-sky-200 p-6 opacity-25 hover:opacity-100 transition duration-150 ease-in-out">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:space-x-5">
                        <div class="flex-shrink-0">
                            <img class="mx-auto h-20 w-20 rounded-full"
                                src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                                alt="">
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                            <blockquote>
                                <p class="text-base text-black font-normal">
                                    “Tailwind CSS is the only framework that I've seen scale
                                    on large teams. It’s easy to customize.”
                                </p>
                            </blockquote>
                            <div class="mt-1">
                                <span class="text-sm text-sky-500 dark:text-sky-400">
                                    Sarah Dayan,
                                </span>
                                <span class="text-sm text-slate-700 dark:text-slate-500">
                                    Staff Engineer, Algolia
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle -->
            <div class="group bg-slate-50 rounded-lg border border-sky-200 p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:space-x-5">
                        <div class="flex-shrink-0">
                            <img class="mx-auto h-20 w-20 rounded-full"
                                src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                                alt="">
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                            <blockquote>
                                <p class="text-base text-black font-normal">
                                    “Tailwind CSS is the only framework that I've seen scale
                                    on large teams. It’s easy to customize.”
                                </p>
                            </blockquote>
                            <div class="mt-1">
                                <span class="text-sm text-sky-500 dark:text-sky-400">
                                    Sarah Dayan,
                                </span>
                                <span class="text-sm text-slate-700 dark:text-slate-500">
                                    Staff Engineer, Algolia
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div
                class="group bg-slate-50 rounded-lg border border-sky-200 p-6 opacity-25 hover:opacity-100 transition duration-150 ease-in-out">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:space-x-5">
                        <div class="flex-shrink-0">
                            <img class="mx-auto h-20 w-20 rounded-full"
                                src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                                alt="">
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                            <blockquote>
                                <p class="text-base text-black font-normal">
                                    “Tailwind CSS is the only framework that I've seen scale
                                    on large teams. It’s easy to customize.”
                                </p>
                            </blockquote>
                            <div class="mt-1">
                                <span class="text-sm text-sky-500 dark:text-sky-400">
                                    Sarah Dayan,
                                </span>
                                <span class="text-sm text-slate-700 dark:text-slate-500">
                                    Staff Engineer, Algolia
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
