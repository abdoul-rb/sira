@section('title', __('Configurez votre boutique'))

<div class="space-y-6" x-data="{
    init() {
            Livewire.on('shop-updated', () => {
                // Rafraîchir la page pour afficher les nouvelles informations de la boutique
                $wire.$refresh()
            })
        },

        shareProducts() {
            // Récupérer l'URL publique de la boutique depuis Livewire
            const publicUrl = @js($this->getPublicShopUrl());

            if (!publicUrl) {
                alert('Impossible de partager : la boutique n\'est pas configurée ou inactive.');
                return;
            }

            // Vérifier si l'API Web Share est supportée
            if (navigator.share) {
                navigator.share({
                    title: '{{ $tenant->shop->name ?? 'Ma boutique' }}',
                    text: 'Découvrez nos produits disponibles !',
                    url: publicUrl
                }).catch((error) => {
                    console.log('Erreur de partage:', error);
                });
            } else {
                navigator.clipboard.writeText(publicUrl).then(() => {
                    alert('Lien de la boutique copié dans le presse-papiers !');
                }).catch(() => {
                    prompt('Copiez ce lien pour partager :', publicUrl);
                });
            }
        }
}">
    <x-ui.breadcrumb :items="[['label' => 'Retour', 'url' => route('dashboard.settings.index')]]" />

    <div class="space-y-2">
        <div class="w-20 h-20 mx-auto rounded-full bg-black flex items-center justify-center elegant-shadow">
            <span class="text-2xl font-bold text-white">M</span>
        </div>

        <!-- Socials -->
        <div class="flex justify-center gap-4">
            <a href="#" target="_self" rel="noopener noreferrer"
                class="p-3 rounded-full border border-gray-200 hover:border-black transition-all duration-300 hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-5 h-5 text-gray-600 hover:text-black">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                </svg>
            </a>

            <a href="#" target="_self" rel="noopener noreferrer"
                class="p-3 rounded-full border border-gray-200 hover:border-black transition-all duration-300 hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-5 h-5 text-gray-600 hover:text-black">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                </svg>
            </a>
        </div>

        <!-- Shop details -->
        <div class="flex items-center justify-center gap-2">
            @if ($tenant->shop)
                <h1 class="text-2xl font-bold text-black tracking-tight">
                    {{ $tenant->shop->name }}
                </h1>
                {{-- @if ($tenant->shop->logo_path)
                        <img src="{{ Storage::disk('public')->url($tenant->shop->logo_path) }}" alt="Logo de la boutique"
                            class="w-8 h-8 rounded-full object-cover">
                    @endif --}}
            @else
                <h1 class="text-2xl font-bold text-black tracking-tight">
                    Ma Boutique
                </h1>
            @endif

            <button @click="$dispatch('open-modal', { id: 'edit-shop' })"
                class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 w-8 h-8 rounded-full hover:bg-gray-100 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-4 h-4 text-gray-400 hover:text-black">
                    <path
                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z">
                    </path>
                </svg>
            </button>
        </div>

        @if ($tenant->shop && $tenant->shop->description)
            <p class="text-center text-gray-600 max-w-md mx-auto">
                {{ $tenant->shop->description }}
            </p>
        @endif

        <!-- Modal d'édition de la boutique -->
        <x-ui.modals.edit-shop-modal :tenant="$tenant" />

        <!-- Share products -->
        <div class="flex justify-center">
            <button @click="shareProducts()"
                class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border h-10 rounded-full px-6 py-2 border-black text-black hover:bg-black hover:text-white transition-all duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-share2 w-4 h-4 mr-2">
                    <circle cx="18" cy="5" r="3"></circle>
                    <circle cx="6" cy="12" r="3"></circle>
                    <circle cx="18" cy="19" r="3"></circle>
                    <line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line>
                    <line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>
                </svg>
                Partager
            </button>
        </div>
    </div>
</div>
