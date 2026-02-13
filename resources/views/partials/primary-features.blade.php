<section id="features" aria-label="Features for running your books"
    class="relative overflow-hidden bg-blue-600 pt-20 pb-28 sm:py-32" x-data="{ selected: 'analytics' }">

    <!-- Background image -->
    <img alt="" loading="lazy" width="2245" height="1636" decoding="async" data-nimg="1"
        class="absolute top-1/2 left-1/2 max-w-none translate-x-[-44%] translate-y-[-42%]" style="color:transparent"
        src="{{ asset('imgs/background-features.jpg') }}">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-2xl md:mx-auto md:text-center xl:max-w-none">
            <h2 class="font-display text-3xl tracking-tight text-white sm:text-4xl md:text-5xl">
                Tout ce qu'il vous faut pour gérer votre business.
            </h2>
            <p class="mt-6 text-lg tracking-tight text-blue-100 max-w-5xl mx-auto">
                Gérez votre boutique sans stress, sans calculs compliqués et sans risque d'erreurs. Sira centralise vos
                opérations pour que vous puissiez anticiper, mieux acheter, éviter les ruptures et comprendre exactement
                ce qui vous rapporte.
            </p>
        </div>

        <div class="mt-16 grid grid-cols-1 items-center gap-y-2 pt-10 sm:gap-y-6 md:mt-20 lg:grid-cols-12 lg:pt-0">
            
            <!-- Onglets -->
            <div class="-mx-4 flex overflow-x-auto pb-4 sm:mx-0 sm:overflow-visible sm:pb-0 lg:col-span-5">
                <div class="relative z-10 flex gap-x-4 px-4 whitespace-nowrap sm:mx-auto sm:px-0 lg:mx-0 lg:block lg:gap-x-0 lg:gap-y-1 lg:whitespace-normal"
                    role="tablist" aria-orientation="vertical">
                    
                    <div class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 bg-white lg:bg-white/10 lg:ring-1 lg:ring-white/10 lg:ring-inset">
                        <h3>
                           <button
                                    @click="selected = 'analytics'"
                                    :class="selected === 'analytics'
                                        ? 'text-blue-600 lg:text-white'
                                        : 'text-blue-100 hover:text-white'"
                                    class="relative z-10 font-display text-lg transition"
                                >
                                    Analytics
                           </button>

                        </h3>
                        <p class="mt-2 hidden text-sm lg:block text-white">
                            Un tableau de bord simple qui montre vos produits les plus vendus, votre rentabilité et les
                            performances de votre boutique en un coup d'œil.
                        </p>
                    </div>

                    <div class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5">
                        <h3>
                            <button @click="selected = 'stock'"
                                :class="selected === 'stock' ? 'text-blue-100' : 'text-white-600'"
                                class="font-display text-lg data-selected:not-data-focus:outline-hidden lg:text-white"
                                role="tab" type="button" aria-selected="false" tabindex="0">
                                <span class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                Stock
                            </button>
                        </h3>
                        <p class="mt-2 hidden text-sm lg:block text-blue-100 group-hover:text-white">
                            Un suivi clair et en temps réel pour éviter les ruptures et réapprovisionner au bon moment.
                        </p>
                    </div>

                    <div class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5">
                        <h3>
                            <button @click="selected = 'ventes'"
                                :class="selected === 'ventes' ? 'text-blue-50' : 'text-white-600'"
                                class="font-display text-lg data-selected:not-data-focus:outline-hidden lg:text-white"
                                role="tab" type="button" aria-selected="false" tabindex="0">
                                <span class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                Ventes
                            </button>
                        </h3>
                        <p class="mt-2 hidden text-sm lg:block text-blue-100 group-hover:text-white">
                            L'enregistrement des ventes quotidiennes en quelques secondes, avec calcul automatique du
                            chiffre d'affaires.
                        </p>
                    </div>

                    <div class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 hover:bg-white/10 lg:hover:bg-white/5">
                        <h3>
                            <button @click="selected = 'contacts'"
                                :class="selected === 'contacts' ? 'text-blue-100' : 'text-white-600'"
                                class="font-display text-lg data-selected:not-data-focus:outline-hidden lg:text-white"
                                role="tab" type="button" aria-selected="false" tabindex="0">
                                <span class="absolute inset-0 rounded-full lg:rounded-l-xl lg:rounded-r-none"></span>
                                Contacts
                            </button>
                        </h3>
                        <p class="mt-2 hidden text-sm lg:block text-blue-100 group-hover:text-white">
                            Un espace unique pour suivre vos fournisseurs, vos clients et leur historique.
                        </p>
                    </div>

                </div>
            </div>

                <div x-show="selected === 'analytics'" class="hidden lg:block mt-10 w-180 overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-blue-900/20 sm:w-auto lg:mt-0 lg:w-271.25">
                    <img alt="" class="w-full" src="{{ asset('imgs/analytics.webp') }}">
                </div>

                <div x-show="selected === 'stock'" class="hidden lg:block mt-10 w-180 overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-blue-900/20 sm:w-auto lg:mt-0 lg:w-271.25">
                    <img alt="" class="w-full" src="{{ asset('imgs/stock.webp') }}">
                </div>

                <div x-show="selected === 'ventes'" class="hidden lg:block mt-10 w-180 overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-blue-900/20 sm:w-auto lg:mt-0 lg:w-271.25">
                    <img alt="" class="w-full" src="{{ asset('imgs/ventes.webp') }}">
                </div>

                <div x-show="selected === 'contacts'" class="hidden lg:block mt-10 w-180 overflow-hidden rounded-xl bg-slate-50 shadow-xl shadow-blue-900/20 sm:w-auto lg:mt-0 lg:w-271.25">
                    <img alt="" class="w-full" src="{{ asset('imgs/contacts.webp') }}">
                </div>

               
               
                <div class="relative sm:px-6 lg:hidden" x-show="selected === 'analytics'">
                    <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center mt-4">
                        Un tableau de bord simple qui montre vos produits les plus vendus, votre rentabilité et les performances de votre boutique en un coup d'œil.
                    </p>
                    <img alt="" class="mt-6 w-full rounded-xl" src="{{ asset('imgs/analytics.webp') }}">
                </div>

               
                <div class="relative sm:px-6 lg:hidden" x-show="selected === 'stock'">
                    <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center mt-4">
                        Un suivi clair et en temps réel pour éviter les ruptures et réapprovisionner au bon moment.
                    </p>
                    <img alt="" class="mt-6 w-full rounded-xl" src="{{ asset('imgs/stock.webp') }}">
                </div>

              
                <div class="relative sm:px-6 lg:hidden" x-show="selected === 'ventes'">
                    <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center mt-4">
                        L'enregistrement des ventes quotidiennes en quelques secondes, avec calcul automatique du chiffre d'affaires.
                    </p>
                    <img alt="" class="mt-6 w-full rounded-xl" src="{{ asset('imgs/ventes.webp') }}">
                </div>

                
                <div class="relative sm:px-6 lg:hidden" x-show="selected === 'contacts'">
                    <p class="relative mx-auto max-w-2xl text-base text-white sm:text-center mt-4">
                        Un espace unique pour suivre vos fournisseurs, vos clients et leur historique.
                    </p>
                    <img alt="" class="mt-6 w-full rounded-xl" src="{{ asset('imgs/contacts.webp') }}">
                </div>

            </div>
        </div>
    </div>
</section>


