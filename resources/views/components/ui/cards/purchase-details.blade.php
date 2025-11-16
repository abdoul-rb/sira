@props(['purchase'])

<li class="overflow-hidden rounded-xl outline outline-gray-200 bg-white">
    <div class="flex items-center gap-x-4 border-b border-gray-900/5 p-6">
        <img src="https://tailwindcss.com/plus-assets/img/logos/48x48/tuple.svg" alt="Tuple"
            class="size-12 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10" />
        <div class="text-sm/6 font-medium text-gray-900">
            {{ $purchase->supplier->name }}
        </div>
        <div class="relative ml-auto" x-data="{ dropdownOpen: false }">
            <button type="button" @click="dropdownOpen = !dropdownOpen"
                class="relative block text-gray-400 hover:text-gray-500 cursor-pointer">
                <span class="absolute -inset-2.5"></span>
                <span class="sr-only">Open options</span>
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                    <path
                        d="M3 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM8.5 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM15.5 8.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                </svg>
            </button>

            <div x-show="dropdownOpen"
                class="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="options-menu-0-button" tabindex="-1">
                <a href="#" wire:click.prevent="edit({{ $purchase->id }})" @click="dropdownOpen = false"
                    class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden hover:bg-gray-50">
                    Modifer
                    <span class="sr-only">, Tuple</span>
                </a>
            </div>
        </div>
        {{-- <el-dropdown class="relative ml-auto">
            <button class="relative block text-gray-400 hover:text-gray-500 cursor-pointer">
                <span class="absolute -inset-2.5"></span>
                <span class="sr-only">Open options</span>
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                    <path
                        d="M3 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM8.5 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM15.5 8.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                </svg>
            </button>
            <el-menu anchor="bottom end" popover
                class="w-32 origin-top-right rounded-md bg-white py-2 shadow-lg outline-1 outline-gray-900/5 transition transition-discrete [--anchor-gap:--spacing(0.5)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                <a href="#"
                    class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden">View<span
                        class="sr-only">, Tuple</span></a>
                <a href="#"
                    class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden">Edit<span
                        class="sr-only">, Tuple</span></a>
            </el-menu>
        </el-dropdown> --}}
    </div>

    <div class="px-6 py-4">
        <div class="flex items-start gap-2 text-sm text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-4 h-4 mt-0.5 text-gray-500 shrink-0">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                <path d="M10 9H8"></path>
                <path d="M16 13H8"></path>
                <path d="M16 17H8"></path>
            </svg>
            <p class="line-clamp-2 leading-relaxed text-sm text-gray-600">
                {{ str($purchase->details)->words(10) }}
            </p>
        </div>
    </div>

    <dl class="-my-3 divide-y divide-gray-100 px-6 py-2 text-sm">
        <div class="flex justify-between gap-x-4 py-3">
            <dt class="text-gray-600">Date d'achat</dt>
            <dd class="text-gray-700">
                {{ $purchase->purchased_at->locale('fr')->format('d M. Y') }}
            </dd>
        </div>
        <div class="flex justify-between gap-x-4 py-3">
            <dt class="text-gray-600">Montant d'achat</dt>
            <dd class="flex items-start gap-x-2">
                <div class="font-medium text-gray-900">
                    {{ Number::currency($purchase->amount, in: 'XOF', locale: 'fr') }}
                </div>
                {{-- <div
                    class="rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10 ring-inset">
                    Overdue
                </div> --}}
            </dd>
        </div>
    </dl>
</li>
