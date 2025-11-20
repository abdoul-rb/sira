@props(['order', 'showCustomerDetails' => true])

<div class="bg-gray-100 border border-gray-200 rounded-lg p-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium text-gray-900 md:shrink-0">
            Vente #{{ strtoupper($order->order_number) }}
        </h2>

        <div class="relative ml-auto" x-data="{ dropdownOpen: false }">
            <button type="button" @click="dropdownOpen = !dropdownOpen"
                class="relative block text-gray-400 hover:text-gray-500 rounded-md p-1 hover:bg-gray-50 cursor-pointer">
                <span class="absolute -inset-2.5"></span>
                <span class="sr-only">Open options</span>
                <svg class="size-5 shrink-0" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z">
                    </path>
                </svg>
            </button>

            <div x-show="dropdownOpen"
                class="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="options-menu-0-button" tabindex="-1">
                <a href="#" @click="dropdownOpen = false"
                    class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden hover:bg-gray-50">
                    Modifer
                    <span class="sr-only">, {{ $order->order_number }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="mt-2 grid grid-cols-2 gap-2">
        <div>
            <h4 class="text-xs text-gray-400">
                Date de la commande
            </h4>
            <p class="mt-1 flex items-center gap-1 text-xs font-medium text-black">
                {{ $order->created_at->format('d/m/Y') }}
            </p>
        </div>

        <div>
            <h4 class="text-xs text-gray-400">
                Total
            </h4>
            <p class="mt-1 flex items-center gap-1 text-xs font-medium text-black">
                {{ $order->total_amount }}
            </p>
        </div>

        <!-- TODO: composant status -->
        <div>
            <h4 class="text-xs text-gray-400">
                Mode de paiement
            </h4>
            <span
                class="inline-flex items-center gap-x-1.5 rounded-full px-1.5 py-0.5 text-xs font-medium {{ $order->payment_status->color() }}">
                <svg viewBox="0 0 6 6" aria-hidden="true" class="size-1.5" fill="currentColor">
                    <circle r="3" cx="3" cy="3" />
                </svg>
                {{ $order->payment_status->label() }}
            </span>
        </div>

        <div>
            <h4 class="text-xs text-gray-400">
                Rémise
            </h4>
            <p class="mt-1 flex items-center gap-1 text-xs font-medium text-black">
                {{ Number::currency($order->discount, in: 'XOF', locale: 'fr') }}
            </p>
        </div>
    </div>

    <div class="mt-3 rounded-lg text-gray-500 p-4 -mx-2 bg-white cursor-pointer">
        @if ($showCustomerDetails)
            <div class="space-y-1 mb-5 border-b border-gray-200 pb-5">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 shrink-0" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z">
                        </path>
                    </svg>
                    <span>{{ $order->customer?->fullname ?? '-' }}</span>
                </div>
                <div class="text-xs text-gray-500 ml-6">
                    {{ $order->customer?->email ?? '-' }} / {{ $order->customer?->phone_number ?? '-' }}
                </div>
            </div>
        @endif

        <div class="space-y-4">
            @forelse ($order->products as $item)
                <div class="flex space-x-4 sm:min-w-0 sm:flex-1">
                    @if ($item->product->featured_image)
                        <img src="{{ Storage::disk('public')->url($item->product->featured_image) }}"
                            alt="{{ $item->product->name }}" class="size-14 flex-none rounded-md object-cover sm:size-16">
                    @else
                        <img src="https://placehold.co/56x56" alt=""
                            class="size-14 flex-none rounded-md object-cover sm:size-16" />
                    @endif
                    <div class="min-w-0 flex-1 pt-1.5 sm:pt-0">
                        <h3 class="text-xs lg:text-sm text-gray-500">
                            <a href="#">{{ $item->product->name }}</a> x {{ $item->quantity }}
                        </h3>
                        <p class="mt-1 text-xs font-medium text-black">
                            {{ Number::currency($item->total_price, in: 'XOF', locale: 'fr') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-gray-400 py-3">
                    Aucun produit dans cette commande.
                </div>
            @endforelse
        </div>
    </div>
</div>