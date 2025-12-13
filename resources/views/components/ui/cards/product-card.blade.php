@props(['product'])

<div class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
    @if ($product->featured_image)
        <img src="{{ Storage::disk('public')->url($product->featured_image) }}" alt="{{ $product->name }}"
            class="w-auto h-56 object-cover group-hover:opacity-75 aspect-auto" />
    @else
        <img src="https://placehold.co/380x224" alt=""
            class="w-auto h-56 object-cover group-hover:opacity-75 aspect-auto" />
    @endif

    <div class="flex flex-1 flex-col justify-between p-4">
        <div class="flex items-start justify-between">
            <div class="text-sm space-y-2">
                <h3 class="font-medium text-black">
                    <a href="#">
                        <span aria-hidden="true" class="absolute inset-0"></span>
                        {{ $product->name }}
                    </a>
                </h3>
                <p class="font-light text-black/50">
                    {{ str()->words($product->description ?? '', 10) }}
                </p>
            </div>

            @role('manager')
            <x-ui.dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button type="button"
                        class="-m-2.5 block p-2 text-gray-400 hover:text-gray-500 cursor-pointer rounded-md hover:bg-gray-50"
                        id="options-menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <svg class="h-5 w-5" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z">
                            </path>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    @can('edit-product')
                        <button type="button" wire:click="edit({{ $product->id }})" @click="dropdownOpen = false"
                            class="w-full block px-3 py-1 text-xs font-medium leading-6 text-gray-900 hover:bg-gray-50 text-left cursor-pointer"
                            role="menuitem" tabindex="-1" id="options-menu-0-item-1">
                            Modifier<span class="sr-only">, </span>
                        </button>
                    @endcan
                    @can('delete-product')
                        <button type="button" wire:click.prevent="destroy({{ $product->id }})"
                            wire:confirm.prompt="Are you sure?\n\nType DELETE to confirm|DELETE"
                            @click="dropdownOpen = false"
                            class="w-full block px-3 py-1 text-xs font-medium leading-6 text-red-600 hover:bg-gray-50 text-left cursor-pointer"
                            role="menuitem" tabindex="-1" id="options-menu-0-item-1">
                            Supprimer
                        </button>
                    @endcan
                </x-slot>
            </x-ui.dropdown>
            @endrole
        </div>

        <div class="mt-4 flex items-center justify-between">
            <p class="text-sm font-medium text-black">
                {{ Number::currency($product->price, in: 'XOF', locale: 'fr') }}
            </p>

            <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full inline-block">
                Stock: {{ $product->stock_quantity }}
            </span>
        </div>
    </div>
</div>