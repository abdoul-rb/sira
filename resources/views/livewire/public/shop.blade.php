<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->name }} - {{ $shop->company->name }}</title>
    <meta name="description" content="{{ $shop->description ?? 'Découvrez nos produits de qualité' }}">

    <!-- Tailwind CSS via CDN pour la simplicité -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header simple -->
    <header class="bg-white shadow-sm border-b py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-900">{{ $shop->name }}</h1>
                @if ($shop->description)
                    <p class="text-gray-600 mt-2 max-w-2xl mx-auto">{{ $shop->description }}</p>
                @endif
            </div>
        </div>
    </header>

    <!-- Barre de recherche -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="max-w-md mx-auto">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher un produit..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Titre de la section -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Nos Produits</h2>
            <p class="text-gray-600">{{ $products->count() }} produit(s) disponible(s)</p>
        </div>

        <!-- Grille des produits -->
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Image du produit -->
                        <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                            @if ($product->featured_image)
                                <img src="{{ Storage::disk('public')->url($product->featured_image) }}"
                                    alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Informations du produit -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>

                            @if ($product->description)
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ Str::limit($product->description, 80) }}</p>
                            @endif

                            <div class="flex items-center justify-between">
                                @if ($product->price)
                                    <span
                                        class="text-xl font-bold text-gray-900">{{ number_format($product->price, 2, ',', ' ') }}
                                        €</span>
                                @else
                                    <span class="text-gray-500">Prix sur demande</span>
                                @endif

                                @if ($product->sku)
                                    <span class="text-xs text-gray-400">Ref: {{ $product->sku }}</span>
                                @endif
                            </div>

                            @if ($product->stock_quantity !== null)
                                <div class="mt-2">
                                    @if ($product->stock_quantity > 0)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            En stock ({{ $product->stock_quantity }})
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Rupture de stock
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Aucun produit trouvé -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun produit trouvé</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if ($search)
                        Aucun produit ne correspond à votre recherche "{{ $search }}".
                    @else
                        Cette boutique n'a pas encore de produits disponibles.
                    @endif
                </p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} {{ $shop->company->name }}. Tous droits réservés.
                </p>
                <p class="text-gray-500 text-sm mt-2">Propulsé par Sira</p>
            </div>
        </div>
    </footer>
</body>

</html>
