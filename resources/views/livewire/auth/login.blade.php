@section('title', __('Se connecter'))

<div class="flex min-h-screen bg-white" x-data="{ role: @entangle('role') }">
    <div class="w-1/2 flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full">
            <div>
                <a href="{{ route('home') }}" class="">
                    <img class="h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                        alt="Your Company">
                </a>

                <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">
                    {{ __('Connectez-vous à votre compte') }}
                </h2>
                <p class="mt-2 text-sm leading-6 text-gray-500">
                    {{ __('Pas encore inscrit ?') }}
                    <a href="{{ route('auth.register') }}" class="font-medium text-sky-600">
                        {{ __('Créer un compte ici') }}
                    </a>
                </p>
            </div>

            <div class="mt-10">
                <form wire:submit.prevent="authenticate" method="POST" class="space-y-6">

                    <x-form.input type="email" name="email" :label="__('Adresse email')" :wire="true" />

                    <x-form.input-password name="password" :label="__('Mot de passe')" :wire="true" />

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input wire:model.lazy="remember" id="remember" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-sky-600 focus:ring-sky-600">
                            <label for="remember" class="ml-2 block text-sm leading-6 text-gray-700">
                                {{ __('Se souvenir de moi') }}
                            </label>
                        </div>

                        <div class="text-sm leading-6">
                            <a href="#{{-- {{ route('password.request') }} --}}" class="text-sm text-sky-600 hover:text-sky-500">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-gray-900 px-3 py-1.5 text-sm font-medium leading-6 text-white shadow-sm focus-visible:outline-offset-2 focus-visible:outline-black cursor-pointer">
                            {{ __('Se connecter') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right column container with background and description-->
    <div class="hidden w-1/2 md:flex items-center bg-gradient-to-tr from-sky-100 via-rose-50 to-teal-100">
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
