@props(['customer'])

<li {{ $attributes->merge(['class' => 'col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow']) }}>
    <div class="flex w-full items-center justify-between space-x-6 p-6">
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
        <div class="size-10 shrink-0 rounded-full bg-black flex items-center justify-center elegant-shadow">
            <span class="text-sm font-medium text-white">
                {{ $customer->initials }}
            </span>
        </div>
    </div>
    <div>
        <div class="-mt-px flex divide-x divide-gray-200">
            <div class="flex w-0 flex-1">
                <button type="button"
                    class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-900">
                    <svg class="size-5 text-gray-400" data-slot="icon" fill="none" stroke-width="1.5"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                        </path>
                    </svg>
                    Commandes
                </button>
            </div>

            <div class="-ml-px flex w-0 flex-1">
                <button type="button"
                    class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-900">
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
