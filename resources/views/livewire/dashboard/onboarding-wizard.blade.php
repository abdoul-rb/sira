<div x-data="{ open: false }" x-show="open" x-cloak x-init="$nextTick(() => { open = true; })"
    @open-modal.window="if ($event.detail.id === 'onboarding-wizard') { open = true; }"
    class="fixed inset-0 z-50 h-dvh w-screen text-gray-700 text-sm font-sans">

    <!-- Backdrop -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500/40 transition-opacity"></div>

    <div class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 flex h-full min-h-full items-stretch justify-end p-4">
            <div x-show="open" x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" @click.stop
                role="dialog" aria-modal="true"
                class="pointer-events-auto relative flex max-h-[calc(100dvh-2rem)] w-full min-w-0 flex-col items-stretch overflow-hidden rounded-2xl bg-white shadow-lg focus:outline-none sm:max-w-xl border border-gray-300"
                tabindex="-1">
                <div data-has-scrolled="false"
                    class="custom-scrollbar relative h-full overflow-x-clip overflow-y-auto transition-all duration-300 pb-24"
                    data-slot="content">
                    <div
                        class="sticky top-0 z-50 border-b border-gray-100 bg-white p-8 transition-colors duration-200 [[data-has-scrolled=true]_&]:border-gray-100!">
                        <div class="absolute top-6 right-6 flex items-center gap-4">
                            <button type="button" @click="open = false"
                                class="shrink-0 cursor-default relative isolate inline-flex items-center justify-center border font-medium whitespace-nowrap focus-visible:shadow-sm data-disabled:cursor-default data-disabled:opacity-50 [&_svg]:shrink-0 [&_svg]:text-(--btn-icon) border-transparent text-gray-400 hover:not-data-disabled:text-gray-500 focus-visible:not-data-disabled:text-gray-700 active:not-data-disabled:text-gray-700 hover:bg-gray-100 hover:bg-gray-200 focus:outline-hidden focus-visible:not-data-disabled:shadow-sm active:not-data-disabled:bg-white active:not-data-disabled:shadow-sm disabled:opacity-50 disabled:hover:bg-transparent data-[state=focus]:not-data-disabled:bg-white! data-[state=focus]:not-data-disabled:shadow-sm! data-[state=open]:not-data-disabled:bg-white data-[state=open]:not-data-disabled:shadow-sm size-8 rounded-md p-0 *:size-5 [&_svg]:size-5">
                                <span
                                    class="pointer-events-none absolute inset-0 flex items-center justify-center opacity-0">
                                    <svg class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="M2.5 10c0 2.071.84 3.946 2.197 5.303A7.5 7.5 0 1010 2.5"></path>
                                    </svg>
                                </span>
                                <span class="inline-flex min-w-0 items-center justify-center gap-x-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-5 stroke-[1.8]"
                                        data-slot="icon">
                                        <path d="M4.75 4.75L19.25 19.25M19.25 4.75L4.75 19.25"></path>
                                    </svg>
                                    <span class="sr-only">Close dialog</span>
                                </span>
                                <span
                                    class="absolute top-1/2 left-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 pointer-fine:hidden"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{  __("Commencer votre essai gratuit") }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            {{ __("Profitez de 3 mois gratuit sans limite") }}
                        </p>
                    </div>

                    <div class="px-8 pb-8">
                        <form wire:submit.prevent="submit" class="space-y-6">
                            <!-- Etape 1 : Entreprise -->
                            @if($step === 1)
                                <h3
                                    class="mt-5 flex items-center gap-2 text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">
                                    <svg class="size-5 text-gray-500" data-slot="icon" fill="none" stroke-width="1.5"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z">
                                        </path>
                                    </svg>

                                    Votre entreprise
                                </h3>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <x-form.label label="Logo de l'entreprise" id="company-logo-upload-label" />

                                        @if ($companyLogo)
                                            <div class="flex items-center gap-4">
                                                <img src="{{ $companyLogo->temporaryUrl() }}" alt="Nouveau logo"
                                                    class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                                                <button type="button" wire:click="$set('companyLogo', null)"
                                                    class="text-xs text-red-500 hover:text-red-700">
                                                    Supprimer
                                                </button>
                                            </div>
                                        @else
                                            <div class="relative">
                                                <input type="file" accept="image/*" wire:model="companyLogo" class="hidden"
                                                    id="company-logo-upload">
                                                <label for="company-logo-upload"
                                                    class="flex flex-col items-center justify-center w-32 h-32 border border-gray-200 border-dashed rounded-xl cursor-pointer hover:border-gray-300 transition-colors">
                                                    <div class="text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="lucide lucide-upload w-6 h-6 text-gray-400 mx-auto mb-2">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="17 8 12 3 7 8"></polyline>
                                                            <line x1="12" x2="12" y1="3" y2="15"></line>
                                                        </svg>
                                                        <span class="text-xs font-medium text-gray-500">
                                                            {{ __('Ajouter un logo') }}
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        @endif

                                        @error('companyLogo')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <x-form.input type="text" name="companyName" label="Nom de l'entreprise" :wire="true" />

                                    <x-form.country-select name="country" label="Pays" :required="true" />
                                </div>
                            @endif

                            <!-- Etape 2 : Boutique -->
                            @if($step === 2)
                                <h3
                                    class="mt-5 flex items-center gap-2 text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">
                                    <svg class="size-5 text-gray-500" data-slot="icon" fill="none" stroke-width="1.5"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                                        </path>
                                    </svg>

                                    Votre boutique
                                </h3>

                                <div class="space-y-4">
                                    <x-form.input type="text" name="shopName" label="Nom de la boutique" :wire="true" />

                                    <div>
                                        <x-form.label label="Description" id="shop-description" />

                                        <textarea wire:model="shopDescription" id="shop-description" name="shopDescription"
                                            rows="4"
                                            class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 placeholder:text-xs focus:border-black focus:border-0 focus:ring-2 focus:ring-black focus:ring-opacity-50 text-xs"
                                            placeholder="Décrivez votre boutique..."></textarea>

                                        @error('shopDescription')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <!-- Etape 3 : Recapitulatif -->
                            @if($step === 3)
                                <h3 class="mt-5 text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">
                                    Récapitulatif
                                </h3>

                                <div class="space-y-4">
                                    <dl class="divide-y divide-gray-100">
                                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">
                                                Entreprise
                                            </dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                {{ $companyName }} ({{ $country }})
                                            </dd>
                                        </div>

                                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">
                                                Boutique
                                            </dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                {{ $shopName }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            @endif

                            <!-- Action -->
                            <div class="mt-6 flex justify-end">
                                <div class="flex items-center gap-x-2">
                                    @if($step > 1)
                                        <button type="button" wire:click="prevStep"
                                            class="inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                            Précédent
                                        </button>
                                    @endif

                                    @if($step < 3)
                                        <button type="button" wire:click="nextStep"
                                            class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                                            Suivant
                                        </button>
                                    @endif

                                    @if($step === 3)
                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                                            Créer ma boutique
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>