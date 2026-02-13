<section id="features" aria-label="Features for running your books"
    class="relative overflow-hidden bg-blue-600 pt-20 pb-28 sm:py-32">
    <img alt="" loading="lazy" width="2245" height="1636" decoding="async" data-nimg="1"
        class="absolute top-1/2 left-1/2 max-w-none translate-x-[-44%] translate-y-[-42%]" style="color:transparent"
        src="https://salient.tailwindui.com/_next/static/media/background-features.5f7a9ac9.jpg">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-2xl md:mx-auto md:text-center xl:max-w-none">
            <h2 class="font-display text-4xl tracking-tight text-white lg:text-5xl">
                Tout ce qu'il vous faut pour gérer votre business.
            </h2>
            <p class="mt-6 text-lg tracking-tight text-blue-100 max-w-5xl mx-auto">
                Gérez votre boutique sans stress, sans calculs compliqués et sans risque d'erreurs. Sira centralise vos
                opérations pour que vous puissiez anticiper, mieux acheter, éviter les ruptures et comprendre exactement
                ce qui vous rapporte.
            </p>
        </div>

        <div class="mt-16 grid grid-cols-1 items-center gap-y-2 pt-10 sm:gap-y-6 md:mt-20 lg:grid-cols-12 lg:pt-0"
            x-data="{ activeTab: 'analytics' }">
            <div
                class="-mx-4 flex overflow-x-auto pb-4 sm:mx-0 sm:overflow-visible sm:pb-0 lg:col-span-5 scroll-smooth scrollbar-hide">
                <div class="relative z-10 flex gap-x-4 px-4 whitespace-nowrap sm:mx-auto sm:px-0 lg:mx-0 lg:block lg:gap-x-0 lg:gap-y-1 lg:whitespace-normal"
                    role="tablist" aria-orientation="vertical">
                    <div @click="activeTab = 'analytics'"
                        class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5"
                        :class="activeTab === 'analytics' ? 'bg-white lg:bg-white/10 lg:ring-1 lg:ring-white/10 lg:ring-inset' : ''">
                        <h3>
                            <button class="font-display text-xl data-selected:not-data-focus:outline-hidden"
                                :class="activeTab === 'analytics' ? 'text-blue-600 lg:text-white' : 'text-white/80'"
                                role="tab" type="button" aria-selected="true" tabindex="0">
                                <span class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                Analytics
                            </button>
                        </h3>
                        <p class="mt-2 hidden text-sm lg:block text-white">
                            {{ __("Un tableau de bord simple qui montre vos produits les plus vendus, votre rentabilité et les performances de votre boutique en un coup d'œil.") }}
                        </p>
                    </div>

                    <div @click="activeTab = 'stock'"
                        class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5"
                        :class="activeTab === 'stock' ? 'bg-white lg:bg-white/10 lg:ring-1 lg:ring-white/10 lg:ring-inset' : ''">
                        <h3>
                            <button class="font-display text-xl data-selected:not-data-focus:outline-hidden"
                                :class="activeTab === 'stock' ? 'text-blue-600 lg:text-white' : 'text-white/80'"
                                role="tab" type="button" aria-selected="true" tabindex="0">
                                <span class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                Stock
                            </button>
                        </h3>
                        <p class="mt-2 hidden text-sm lg:block text-blue-100 group-hover:text-white">
                            {{ __("Un suivi clair et en temps réel pour éviter les ruptures et réapprovisionner au bon moment.") }}
                        </p>
                    </div>

                    <div @click="activeTab = 'ventes'"
                        class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5"
                        :class="activeTab === 'ventes' ? 'bg-white lg:bg-white/10 lg:ring-1 lg:ring-white/10 lg:ring-inset' : ''">
                        <h3>
                            <button class="font-display text-xl data-selected:not-data-focus:outline-hidden"
                                :class="activeTab === 'ventes' ? 'text-blue-600 lg:text-white' : 'text-white/80'"
                                role="tab" type="button" aria-selected="true" tabindex="0">
                                <span class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                Ventes
                            </button>
                        </h3>
                        <p class="mt-2 hidden text-sm lg:block text-blue-100 group-hover:text-white">
                            {{ __("L'enregistrement des ventes quotidiennes en quelques secondes, avec calcul automatique du chiffre d'affaires.") }}
                        </p>
                    </div>

                    <div @click="activeTab = 'contacts'"
                        class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5"
                        :class="activeTab === 'contacts' ? 'bg-white lg:bg-white/10 lg:ring-1 lg:ring-white/10 lg:ring-inset' : ''">
                        <h3>
                            <button class="font-display text-xl data-selected:not-data-focus:outline-hidden"
                                :class="activeTab === 'contacts' ? 'text-blue-600 lg:text-white' : 'text-white/80'"
                                role="tab" type="button" aria-selected="true" tabindex="0">
                                <span class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                Contacts
                            </button>
                        </h3>
                        <p class="mt-2 hidden text-sm lg:block text-blue-100 group-hover:text-white">
                            {{ __("Un espace unique pour suivre vos fournisseurs, vos clients et leur historique.") }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div x-show="activeTab === 'analytics'" id="analytics-panel" role="tabpanel" tabindex="0"
                    aria-labelledby="analytics-panel">
                    <div class="relative sm:px-6 lg:hidden">
                        <div
                            class="absolute -inset-x-4 -top-26 -bottom-17 bg-white/10 ring-1 ring-white/10 ring-inset sm:inset-x-0 sm:rounded-t-xl">
                        </div>
                        <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center">
                            {{ __("Un tableau de bord simple qui montre vos produits les plus vendus, votre rentabilité et les performances de votre boutique en un coup d'œil.") }}
                        </p>
                    </div>
                    <div
                        class="mt-10 w-180 overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-blue-900/20 sm:w-auto lg:mt-0 lg:w-271.25">
                        <img alt="" width="2174" height="1464" decoding="async" data-nimg="1" class="w-full"
                            style="color:transparent"
                            sizes="(min-width: 1024px) 67.8125rem, (min-width: 640px) 100vw, 45rem"
                            srcset="{{ asset('imgs/analytics.webp') }} 640w, {{ asset('imgs/analytics.webp') }} 750w, {{ asset('imgs/analytics.webp') }} 828w"
                            src="{{ asset('imgs/analytics.webp') }}">
                    </div>
                </div>

                <div x-show="activeTab === 'stock'" id="stock-panel" role="tabpanel" tabindex="-1"
                    aria-labelledby="stock-tab">
                    <div class="relative sm:px-6 lg:hidden">
                        <div
                            class="absolute -inset-x-4 -top-26 -bottom-17 bg-white/10 ring-1 ring-white/10 ring-inset sm:inset-x-0 sm:rounded-t-xl">
                        </div>
                        <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center">
                            {{ __("Un suivi clair et en temps réel pour éviter les ruptures et réapprovisionner au bon moment.") }}
                        </p>
                    </div>
                    <div
                        class="mt-10 w-180 overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-blue-900/20 sm:w-auto lg:mt-0 lg:w-271.25">
                        <img alt="" width="2174" height="1464" decoding="async" data-nimg="1" class="w-full"
                            style="color:transparent"
                            sizes="(min-width: 1024px) 67.8125rem, (min-width: 640px) 100vw, 45rem"
                            srcset="{{ asset('imgs/stock.webp') }} 640w, {{ asset('imgs/stock.webp') }} 750w, {{ asset('imgs/stock.webp') }} 828w"
                            src="{{ asset('imgs/stock.webp') }}">
                    </div>
                </div>

                <div x-show="activeTab === 'ventes'" id="ventes-panel" role="tabpanel" aria-labelledby="ventes-panel">
                    <div class="relative sm:px-6 lg:hidden">
                        <div
                            class="absolute -inset-x-4 -top-26 -bottom-17 bg-white/10 ring-1 ring-white/10 ring-inset sm:inset-x-0 sm:rounded-t-xl">
                        </div>
                        <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center">
                            {{ __("L'enregistrement des ventes quotidiennes en quelques secondes, avec calcul automatique du chiffre d'affaires.") }}
                        </p>
                    </div>
                    <div
                        class="mt-10 w-180 overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-blue-900/20 sm:w-auto lg:mt-0 lg:w-271.25">
                        <img alt="" width="2174" height="1464" decoding="async" data-nimg="1" class="w-full"
                            style="color:transparent"
                            sizes="(min-width: 1024px) 67.8125rem, (min-width: 640px) 100vw, 45rem"
                            srcset="{{ asset('imgs/ventes.webp') }} 640w, {{ asset('imgs/ventes.webp') }} 750w, {{ asset('imgs/ventes.webp') }} 828w"
                            src="{{ asset('imgs/ventes.webp') }}">
                    </div>
                </div>

                <div x-show="activeTab === 'contacts'" id="contacts-panel" role="tabpanel"
                    aria-labelledby="contacts-panel">
                    <div class="relative sm:px-6 lg:hidden">
                        <div
                            class="absolute -inset-x-4 -top-26 -bottom-17 bg-white/10 ring-1 ring-white/10 ring-inset sm:inset-x-0 sm:rounded-t-xl">
                        </div>
                        <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center">
                            {{ __("Un espace unique pour suivre vos fournisseurs, vos clients et leur historique.") }}
                        </p>
                    </div>
                    <div
                        class="mt-10 w-180 overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-blue-900/20 sm:w-auto lg:mt-0 lg:w-271.25">
                        <img alt="" width="2174" height="1464" decoding="async" data-nimg="1" class="w-full"
                            style="color:transparent"
                            sizes="(min-width: 1024px) 67.8125rem, (min-width: 640px) 100vw, 45rem"
                            srcset="{{ asset('imgs/contacts.webp') }} 640w, {{ asset('imgs/contacts.webp') }} 750w, {{ asset('imgs/contacts.webp') }} 828w"
                            src="{{ asset('imgs/contacts.webp') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>