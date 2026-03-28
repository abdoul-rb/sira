<form wire:submit.prevent="update" class="grid grid-cols-1 lg:grid-cols-6 gap-4" novalidate>
    <!-- Logo -->
    <div class="lg:col-span-3">
        <div class="col-span-full">
            @if ($logo)
                <div class="flex items-center gap-x-4">
                    <img src="{{ $logo->temporaryUrl() }}" class="size-24 lg:size-32 object-cover rounded-md">

                    <button type="button" wire:click="removeTempLogo" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-2 py-1.5 text-xs text-black cursor-pointer">
                        {{ __('Supprimer') }}
                    </button>
                </div>
            @elseif ($currentLogoPath)
                <div class="flex items-center gap-x-4">
                    <img src="{{ $currentLogoPath }}" alt="{{ $name }}" class="size-24 lg:size-32 object-cover rounded-md">

                    {{-- <button type="button" wire:click="#" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-2 py-1.5 text-xs text-black cursor-pointer">
                        {{ __('Supprimer') }}
                    </button> --}}
                </div>
            @else
                <div class="relative">
                    <input type="file" accept="image/*" wire:model="logo" class="hidden" id="logo">
                    <label for="logo"
                        class="flex flex-col items-center justify-center w-full h-28 border border-gray-200 border-dashed rounded-xl cursor-pointer hover:border-gray-300 transition-colors">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-upload w-6 h-6 text-gray-400 mx-auto mb-2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" x2="12" y1="3" y2="15">
                                </line>
                            </svg>
                            <span class="text-sm text-gray-500">
                                {{ __('Ajouter votre logo') }}
                            </span>
                        </div>
                    </label>
                </div>
            @endif
        </div>

        @error('logo')
            <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <x-form.input class="lg:col-span-4 cursor-not-allowed" name="name" label="Nom" :wire="true" :required="true"
        :disabled="true" />

    <div class="lg:col-span-full gap-4 grid grid-cols-1 md:grid-cols-2">
        <x-form.input name="facebookUrl" label="URL Facebook" type="url" :wire="true"
            placeholder="https://facebook.com/votre-page" />

        <x-form.input name="instagramUrl" label="URL Instagram" type="url" :wire="true"
            placeholder="https://instagram.com/votre-compte" />
            
        <x-form.input name="tiktokUrl" label="URL TikTok" type="url" :wire="true"
            placeholder="https://tiktok.com/@votre-compte" />
    </div>

    <div class="col-span-full flex justify-between gap-3">
        <x-ui.btn.primary type="submit" :icon="false">
            {{ __('Enregistrer') }}
        </x-ui.btn.primary>
    </div>
</form>