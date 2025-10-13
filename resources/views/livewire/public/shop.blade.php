@section('title', "{$shop->name} - {$shop->company->name}")

<div class="bg-gray-50">
    <header class="space-y-2 py-8 border-b border-gray-100">
        @if ($shop->logo_path)
            <img src="{{ $shop->getLogoPath() }}" alt="Logo actuel"
                class="w-24 h-24 mx-auto object-cover rounded-full border border-gray-200">
        @else
            <div class="w-20 h-20 mx-auto rounded-full bg-black flex items-center justify-center elegant-shadow">
                <span class="text-2xl font-bold text-white">{{ $shop->name[0] }}</span>
            </div>
        @endif

        <!-- Shop details -->
        <div class="flex items-center justify-center gap-2">
            <h1 class="text-2xl font-bold text-black tracking-tight">
                {{ $shop->name }}
            </h1>
        </div>

        <p class="text-center text-gray-600 max-w-2xl mx-auto">
            {{ $shop->description }}
        </p>

        <!-- Socials -->
        <p class="text-sm font-medium text-center text-gray-600">Suivez-nous</p>

        <div class="flex justify-center gap-4">
            <a href="#" target="_self" rel="noopener noreferrer"
                class="p-3 rounded-full border border-gray-200 hover:border-black transition-all duration-300 hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-instagram w-5 h-5 text-gray-600 hover:text-black">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                </svg>
            </a>

            <a href="#" target="_self" rel="noopener noreferrer"
                class="p-3 rounded-full border border-gray-200 hover:border-black transition-all duration-300 hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-facebook w-5 h-5 text-gray-600 hover:text-black">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                </svg>
            </a>
        </div>
    </header>

    <!-- Contenu principal -->
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Titre de la section -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Nos Produits</h2>
                <p class="text-gray-600">{{ $products->count() }} produit(s) disponible(s)</p>
            </div>

            <!-- Grille des produits -->
            <div class="grid grid-cols-1 gap-x-3 gap-y-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($products as $product)
                    <x-ui.cards.product-card-public :product="$product" />
                @empty
                    <div class="text-center text-gray-400 py-8">
                        Aucun produit trouvé.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-gray-50 max-w-4xl mx-auto">
        <div class="bg-white rounded-lg  border border-gray-200 p-8 md:p-12 text-center">
            <div class="space-y-6">
                <div class="space-y-4">
                    <h2 class="text-2xl md:text-3xl font-bold text-black">Une question ? Contactez-nous !</h2>
                    <p class="text-black/60 text-base max-w-xl mx-auto">
                        Notre équipe commerciale est disponible pour vous conseiller et vous accompagner dans vos
                        projets technologiques.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
                    <a href="mailto:contact@techstore.com"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-blue-600 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-11 rounded-md px-8 bg-blue-600 hover:bg-blue-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="h-4 w-4 mr-2">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                        Envoyer un email
                    </a>

                    <a href="tel:+33 1 23 45 67 89"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-gray-200 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-gray-200 bg-gray-50 h-11 rounded-md px-8 hover:bg-blue-600 hover:text-white hover:border-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="h-4 w-4 mr-2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                        Nous appeler
                    </a>
                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-gray-200 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-gray-200 bg-gray-50 h-11 rounded-md px-8 hover:bg-blue-600 hover:text-white hover:border-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="h-4 w-4 mr-2">
                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path>
                        </svg>
                        Demande personnalisée
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    {{-- <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} {{ $shop->company->name }}. Tous droits réservés.
                </p>
                <p class="text-gray-500 text-sm mt-2">Propulsé par Sira</p>
            </div>
        </div>
    </footer> --}}
</div>
