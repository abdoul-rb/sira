<div>
    <form wire:submit.prevent="save" class="space-y-6" enctype="multipart/form-data" novalidate>
        <!-- Logo de la boutique -->
        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700">
                {{ __('Logo de la boutique') }}
            </label>
            
            @if ($logo_path || $new_logo)
                <div class="flex items-center gap-4">
                    @if ($new_logo)
                        <img src="{{ $new_logo->temporaryUrl() }}" alt="Nouveau logo" 
                             class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                    @elseif ($logo_path)
                        <img src="{{ Storage::disk('public')->url($logo_path) }}" alt="Logo actuel" 
                             class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                    @endif
                    
                    <button type="button" wire:click="$set('new_logo', null)" 
                            class="text-sm text-red-600 hover:text-red-800">
                        Supprimer
                    </button>
                </div>
            @endif
            
            @if (!$new_logo && !$logo_path)
                <div class="relative">
                    <input type="file" accept="image/*" wire:model="new_logo" class="hidden" id="logo-upload">
                    <label for="logo-upload"
                        class="flex flex-col items-center justify-center w-full h-24 border border-gray-200 border-dashed rounded-xl cursor-pointer hover:border-gray-300 transition-colors">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-upload w-6 h-6 text-gray-400 mx-auto mb-2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" x2="12" y1="3" y2="15"></line>
                            </svg>
                            <span class="text-sm text-gray-500">
                                {{ __('Ajouter un logo') }}
                            </span>
                        </div>
                    </label>
                </div>
            @endif
            
            @error('new_logo')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Informations générales -->
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    {{ __('Nom de la boutique') }}
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" wire:model="name" id="name" name="name"
                    class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-2 focus:ring-black focus:ring-opacity-50 text-sm">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">
                    {{ __('Description') }}
                </label>
                <textarea wire:model="description" id="description" name="description" rows="4"
                    class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-2 focus:ring-black focus:ring-opacity-50 text-sm"
                    placeholder="Décrivez votre boutique..."></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Réseaux sociaux') }}</h3>
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="facebook_url" class="block text-sm font-medium text-gray-700">
                        {{ __('URL Facebook') }}
                    </label>
                    <input type="url" wire:model="facebook_url" id="facebook_url" name="facebook_url"
                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-2 focus:ring-black focus:ring-opacity-50 text-sm"
                        placeholder="https://facebook.com/votre-page">
                    @error('facebook_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="instagram_url" class="block text-sm font-medium text-gray-700">
                        {{ __('URL Instagram') }}
                    </label>
                    <input type="url" wire:model="instagram_url" id="instagram_url" name="instagram_url"
                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-2 focus:ring-black focus:ring-opacity-50 text-sm"
                        placeholder="https://instagram.com/votre-compte">
                    @error('instagram_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Statut -->
        <div class="flex items-center">
            <input type="checkbox" wire:model="active" id="active" name="active"
                class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
            <label for="active" class="ml-2 block text-sm text-gray-900">
                {{ __('Boutique active') }}
            </label>
        </div>

        <!-- Boutons d'action -->
        <div class="flex justify-between gap-3 pt-4">
            <button type="button" @click="$dispatch('close-modal', { id: 'edit-shop' })"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
                {{ __('Annuler') }}
            </button>

            <button type="submit"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black hover:bg-gray-800">
                {{ $shop->exists ? __('Mettre à jour') : __('Créer') }}
            </button>
        </div>
    </form>
</div>
