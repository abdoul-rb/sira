<section id="pricing" aria-label="Pricing" class="bg-slate-900 py-20 sm:py-32">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="md:text-center">
            <h2 class="font-display text-3xl tracking-tight text-white sm:text-4xl">
                Un prix
                <span class="relative whitespace-nowrap">
                    <svg aria-hidden="true" viewBox="0 0 281 40" preserveAspectRatio="none"
                        class="absolute top-1/2 left-0 h-[1em] w-full fill-blue-400">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M240.172 22.994c-8.007 1.246-15.477 2.23-31.26 4.114-18.506 2.21-26.323 2.977-34.487 3.386-2.971.149-3.727.324-6.566 1.523-15.124 6.388-43.775 9.404-69.425 7.31-26.207-2.14-50.986-7.103-78-15.624C10.912 20.7.988 16.143.734 14.657c-.066-.381.043-.344 1.324.456 10.423 6.506 49.649 16.322 77.8 19.468 23.708 2.65 38.249 2.95 55.821 1.156 9.407-.962 24.451-3.773 25.101-4.692.074-.104.053-.155-.058-.135-1.062.195-13.863-.271-18.848-.687-16.681-1.389-28.722-4.345-38.142-9.364-15.294-8.15-7.298-19.232 14.802-20.514 16.095-.934 32.793 1.517 47.423 6.96 13.524 5.033 17.942 12.326 11.463 18.922l-.859.874.697-.006c2.681-.026 15.304-1.302 29.208-2.953 25.845-3.07 35.659-4.519 54.027-7.978 9.863-1.858 11.021-2.048 13.055-2.145a61.901 61.901 0 0 0 4.506-.417c1.891-.259 2.151-.267 1.543-.047-.402.145-2.33.913-4.285 1.707-4.635 1.882-5.202 2.07-8.736 2.903-3.414.805-19.773 3.797-26.404 4.829Zm40.321-9.93c.1-.066.231-.085.29-.041.059.043-.024.096-.183.119-.177.024-.219-.007-.107-.079ZM172.299 26.22c9.364-6.058 5.161-12.039-12.304-17.51-11.656-3.653-23.145-5.47-35.243-5.576-22.552-.198-33.577 7.462-21.321 14.814 12.012 7.205 32.994 10.557 61.531 9.831 4.563-.116 5.372-.288 7.337-1.559Z">
                        </path>
                    </svg>
                    <span class="relative">simple et transparent</span>
                </span>
            </h2>

            <p class="mt-4 text-lg text-slate-400">
                Commencez gratuitement, évoluez quand vous êtes prêt
            </p>
        </div>

        <div class="-mx-4 mt-12 grid max-w-2xl grid-cols-1 gap-y-10 lg:mx-auto lg:max-w-4xl lg:grid-cols-2 lg:gap-x-8">
            <section class="flex flex-col rounded-3xl px-6 sm:px-8 lg:py-8">
                <h3 class="mt-5 font-display text-lg text-white">Gratuit</h3>
                <p class="mt-2 text-base text-slate-400">
                    Pour démarrer et tester Sira
                </p>

                <div class="order-first">
                    <p class="font-display text-5xl font-light tracking-tight text-white">
                        0
                        <span class="text-xl">FCFA</span>
                    </p>
                    <span class="block text-sm font-light text-white">pour toujours</span>
                </div>

                <ul role="list" class="order-last mt-10 flex flex-col gap-y-3 text-sm text-slate-200">
                    @foreach (["Jusqu'à 10 produits", "Gestion des ventes", "Suivi du stock", "Tableau de bord basique", "Support par email"] as $item)
                        <li class="flex items-center">
                            <svg aria-hidden="true" class="h-6 w-6 flex-none fill-current stroke-current text-slate-400">
                                <path
                                    d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                    stroke-width="0"></path>
                                <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></circle>
                            </svg>
                            <span class="ml-3">
                                {{ $item }}
                            </span>
                        </li>
                    @endforeach
                </ul>

                <a href="#"
                    class="group inline-flex ring-1 items-center justify-center rounded-full py-2 px-4 text-sm ring-slate-700 text-white hover:ring-slate-500 active:ring-slate-700 active:text-slate-400 focus-visible:outline-white mt-8"
                    aria-label="Démarrer gratuitement">
                    Commencer gratuitement
                </a>
            </section>

            <section class="flex flex-col rounded-3xl px-6 sm:px-8 order-first bg-blue-600 py-8 lg:order-0">
                <h3 class="mt-5 font-display text-lg text-white">
                    Pro
                </h3>
                <p class="mt-2 text-base text-white">
                    Pour développer votre boutique
                </p>
                <div class="order-first">
                    <p class="font-display text-5xl font-light tracking-tight text-white">
                        8 000 <span class="text-xl">FCFA</span>
                    </p>
                    <span class="block text-sm font-light text-white">
                        par mois, par utilisateur
                    </span>
                </div>

                <ul role="list" class="order-last mt-10 flex flex-col gap-y-3 text-sm text-white">
                    @foreach (["Produits illimités", "Gestion des ventes avancée", "Alertes de stock automatiques", "Tableau de bord complet", "Historique et rapports", "Accès communauté WhatsApp", "Support prioritaire"] as $item)
                        <li class="flex items-center">
                            <svg aria-hidden="true" class="h-6 w-6 flex-none fill-current stroke-current text-white">
                                <path
                                    d="M9.307 12.248a.75.75 0 1 0-1.114 1.004l1.114-1.004ZM11 15.25l-.557.502a.75.75 0 0 0 1.15-.043L11 15.25Zm4.844-5.041a.75.75 0 0 0-1.188-.918l1.188.918Zm-7.651 3.043 2.25 2.5 1.114-1.004-2.25-2.5-1.114 1.004Zm3.4 2.457 4.25-5.5-1.187-.918-4.25 5.5 1.188.918Z"
                                    stroke-width="0"></path>
                                <circle cx="12" cy="12" r="8.25" fill="none" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></circle>
                            </svg>
                            <span class="ml-3">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
                <a href="#"
                    class="group inline-flex items-center justify-center rounded-full py-2 px-4 text-sm font-semibold focus-visible:outline-2 focus-visible:outline-offset-2 bg-white text-slate-900 hover:bg-blue-50 active:bg-blue-200 active:text-slate-600 focus-visible:outline-white mt-8"
                    aria-label="Passer au pro avec 8000 CFA par mois par utilisateur">
                    Passer au pro
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </section>
        </div>

        <p class="mt-12 text-base font-light text-slate-400 text-center">
            Sans engagement. Annulez à tout moment.
        </p>
    </div>
</section>