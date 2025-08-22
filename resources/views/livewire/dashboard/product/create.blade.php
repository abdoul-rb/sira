<div>
    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" enctype="multipart/form-data" novalidate>
        <div class="relative col-span-full">
            <input type="file" accept="image/*" wire:model="featured_image" class="hidden" id="image-upload">
            <label for="image-upload"
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
                        {{ __('Ajouter une photo') }}
                    </span>
                </div>
            </label>
        </div>

        @if ($featured_image)
            <div class="col-span-full">
                <img src="{{ $featured_image->temporaryUrl() }}" alt="Image du produit"
                    class="w-40 h-40 object-cover rounded-md">
            </div>
        @endif

        <x-form.input class="col-span-full" name="name" label="Nom du produit" :wire="true" :required="true" />

        <div class="col-span-full">
            <label for="description" class="block text-sm font-medium text-gray-700">
                {{ __('Description') }}
                <span class="text-red-500">*</span>
            </label>
            <div class="mt-1">
                <textarea rows="4" name="description" wire:model.live="description" id="description"
                    class="block w-full rounded-md border border-gray-300 py-2 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-black text-sm sm:leading-6"></textarea>
            </div>
        </div>

        <x-form.input class="col-span-1" name="price" label="Prix" type="number" :number="true"
            :required="true" />

        <x-form.input class="col-span-1" name="stock_quantity" label="Quantité" type="number" :number="true"
            :required="true" />

        <!-- Boutons d'action -->
        <div class="col-span-full flex justify-between gap-3 pt-2">
            <button type="button" @click="$dispatch('close-modal')"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
                {{ __('Annuler') }}
            </button>

            <button type="submit"
                class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black">
                {{ __('Enregistrer') }}
            </button>
        </div>
    </form>
</div>
