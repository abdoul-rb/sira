@props(['customer'])

<li {{ $attributes->merge(['class' => 'col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow']) }}>
    <div class="flex w-full items-center justify-between space-x-6 p-6">
        <div class="flex items-center gap-x-2">
            <div class="size-10 shrink-0 rounded-full bg-black flex items-center justify-center">
                <span class="text-sm font-medium text-white">
                    {{ $customer->initials }}
                </span>
            </div>

            <div class="flex-1 truncate">
                <div class="flex items-center space-x-3">
                    <h3 class="truncate text-sm font-medium text-gray-900">
                        {{ $customer->fullname }}
                    </h3>
                    <span
                        class="inline-flex shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs text-green-700 ring-1 ring-inset ring-green-600/20">
                        {{ $customer->type->label() }}
                    </span>
                </div>
                <a href="mailto:{{ $customer->email }}" class="mt-1 truncate text-sm text-gray-500">
                    {{ $customer->email }}
                </a>
            </div>
        </div>

        @can('update', $customer)
            <div class="relative ml-auto" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" type="button"
                    class="-m-2.5 block p-2 text-gray-400 hover:text-gray-500 cursor-pointer rounded-md hover:bg-gray-50"
                    id="options-menu-0-button" aria-expanded="false" aria-haspopup="true"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95">
                    <span class="sr-only">Open options</span>
                    <svg class="h-5 w-5" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z">
                        </path>
                    </svg>
                </button>

                <div x-show="dropdownOpen"
                    class="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="options-menu-0-button" tabindex="-1">
                    <a href="#" class="block px-3 py-1 text-xs font-medium leading-6 text-gray-900 hover:bg-gray-50"
                        role="menuitem" tabindex="-1" id="options-menu-0-item-0">
                        Voir <span class="sr-only"></span>
                    </a>
                    <button type="button" wire:click="edit({{ $customer->id }})" @click="dropdownOpen = false"
                        class="w-full block px-3 py-1 text-xs font-medium leading-6 text-gray-900 hover:bg-gray-50 text-left cursor-pointer"
                        role="menuitem" tabindex="-1" id="options-menu-0-item-1">
                        Modifier<span class="sr-only">, </span>
                    </button>
                </div>
            </div>
        @endcan
    </div>

    <div>
        <div class="-mt-px flex divide-x divide-gray-200">
            <div class="flex w-0 flex-1">
                <button type="button"
                    class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-900 hover:bg-gray-50 transition-colors cursor-pointer"
                    @click="$dispatch('open-modal', { id: 'show-customer-orders-{{ $customer->id }}' })">
                    <svg class="size-5 text-gray-400" data-slot="icon" fill="none" stroke-width="1.5"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                        </path>
                    </svg>
                    Commandes
                </button>
            </div>

            <div class="-ml-px flex w-0 flex-1">
                <button type="button"
                    class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-900 cursor-pointer">
                    <svg class="size-5 text-gray-400" data-slot="icon" fill="none" stroke-width="1.5"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z">
                        </path>
                    </svg>
                    Crédits
                </button>
            </div>
        </div>
    </div>
</li>
