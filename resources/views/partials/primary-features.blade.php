<section id="features"
    class="relative overflow-hidden bg-blue-600 pt-20 pb-28 sm:py-32"
    x-data="{ activeTab: 0 }">

    <img alt="" loading="lazy"
        class="absolute top-1/2 left-1/2 max-w-none translate-x-[-44%] translate-y-[-42%]"
        src="https://salient.tailwindui.com/_next/static/media/background-features.5f7a9ac9.jpg">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">

        <!-- TITRE -->
        <div class="max-w-2xl md:mx-auto md:text-center xl:max-w-none">
            <h2 class="font-display text-3xl tracking-tight text-white sm:text-4xl md:text-5xl">
                Tout ce qu'il vous faut pour gérer votre business.
            </h2>
            <p class="mt-6 text-lg tracking-tight text-blue-100 max-w-5xl mx-auto">
                Gérez votre boutique sans stress, sans calculs compliqués et sans risque d'erreurs.
                Sira centralise vos opérations pour que vous puissiez anticiper, mieux acheter,
                éviter les ruptures et comprendre exactement ce qui vous rapporte.
            </p>
        </div>

        <div class="mt-16 grid grid-cols-1 items-center gap-y-2 pt-10 sm:gap-y-6 md:mt-20 lg:grid-cols-12 lg:pt-0">

            <!-- TABS GAUCHE -->
            <div class="-mx-4 flex overflow-x-auto pb-4 sm:mx-0 sm:overflow-visible sm:pb-0 lg:col-span-5">
                <div class="relative z-10 flex gap-x-4 px-4 whitespace-nowrap sm:mx-auto sm:px-0
                            lg:mx-0 lg:block lg:gap-x-0 lg:gap-y-1 lg:whitespace-normal"
                    role="tablist">

                    <!-- TAB 0 -->
                    <div :class="activeTab === 0 ? 'bg-white lg:bg-white/10 ring-1 ring-white/10' : ''"
                        class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 cursor-pointer">
                        <button class="font-display text-lg text-blue-600 lg:text-white"
                            role="tab"
                            :aria-selected="activeTab === 0"
                            @click="activeTab = 0">
                            Analytics
                        </button>
                        <p class="mt-2 hidden text-sm lg:block text-white">
                            Un tableau de bord simple qui montre vos produits les plus vendus,
                            votre rentabilité et les performances de votre boutique.
                        </p>
                    </div>

                    <!-- TAB 1 -->
                    <div :class="activeTab === 1 ? 'bg-white lg:bg-white/10 ring-1 ring-white/10' : ''"
                        class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 cursor-pointer">
                        <button class="font-display text-lg text-blue-600 lg:text-white"
                            role="tab"
                            :aria-selected="activeTab === 1"
                            @click="activeTab = 1">
                            Stock
                        </button>
                        <p class="mt-2 hidden text-sm lg:block"
                           :class="activeTab === 1 ? 'text-white' : 'text-blue-100'">
                            Suivi clair et en temps réel pour éviter les ruptures.
                        </p>
                    </div>

                    <!-- TAB 2 -->
                    <div :class="activeTab === 2 ? 'bg-white lg:bg-white/10 ring-1 ring-white/10' : ''"
                        class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 cursor-pointer">
                        <button class="font-display text-lg text-blue-600 lg:text-white"
                            role="tab"
                            :aria-selected="activeTab === 2"
                            @click="activeTab = 2">
                            Ventes
                        </button>
                        <p class="mt-2 hidden text-sm lg:block"
                           :class="activeTab === 2 ? 'text-white' : 'text-blue-100'">
                            Enregistrement rapide des ventes avec calcul automatique du chiffre d'affaires.
                        </p>
                    </div>

                    <!-- TAB 3 -->
                    <div :class="activeTab === 3 ? 'bg-white lg:bg-white/10 ring-1 ring-white/10' : ''"
                        class="group relative rounded-full px-4 py-1 lg:rounded-l-xl lg:rounded-r-none lg:p-6 cursor-pointer">
                        <button class="font-display text-lg text-blue-600 lg:text-white"
                            role="tab"
                            :aria-selected="activeTab === 3"
                            @click="activeTab = 3">
                            Contacts
                        </button>
                        <p class="mt-2 hidden text-sm lg:block"
                           :class="activeTab === 3 ? 'text-white' : 'text-blue-100'">
                            Un espace unique pour suivre fournisseurs, clients et historique.
                        </p>
                    </div>

                </div>
            </div>

            <!-- PANELS DROITE -->
            <div class="lg:col-span-7">

                <!-- PANEL 0 -->
                <div x-show="activeTab === 0" x-transition>
                    <img src="{{ asset('imgs/analytics.webp') }}"
                        class="w-full rounded-xl shadow-xl" alt="Analytics">
                </div>

                <!-- PANEL 1 -->
                <div x-show="activeTab === 1" x-transition>
                    <img src="{{ asset('imgs/stock.webp') }}"
                        class="w-full rounded-xl shadow-xl" alt="Stock">
                </div>

                <!-- PANEL 2 -->
                <div x-show="activeTab === 2" x-transition>
                    <img src="{{ asset('imgs/ventes.webp') }}"
                        class="w-full rounded-xl shadow-xl" alt="Ventes">
                </div>

                <!-- PANEL 3 -->
                <div x-show="activeTab === 3" x-transition>
                    <img src="{{ asset('imgs/contacts.webp') }}"
                        class="w-full rounded-xl shadow-xl" alt="Contacts">
                </div>

            </div>
        </div>
    </div>
</section>
