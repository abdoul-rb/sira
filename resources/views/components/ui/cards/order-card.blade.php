@props(['order', 'showCustomerDetails' => true])

<div class="bg-gray-100 border border-gray-200 rounded-lg p-4">
    <h2 class="text-lg font-medium text-gray-900 md:shrink-0">
        Commande #{{ strtoupper($order->order_number) }}
    </h2>

    <div class="mt-2 grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <h4 class="text-xs text-gray-400">
                Date de la commande
            </h4>
            <p class="mt-1 flex items-center gap-1 text-xs font-medium text-black">
                {{ $order->created_at->format('d/m/Y') }}
            </p>
        </div>

        <div>
            <h4 class="text-xs text-gray-400">
                Status
            </h4>
            <p class="mt-1 flex items-center gap-1 text-xs font-medium text-black">
                <span class="inline-block w-2 h-2 rounded-full {{ $order->status->color() }}"></span>
                {{ $order->status->label() }}
            </p>
        </div>

        <div>
            <h4 class="text-xs text-gray-400">
                Total
            </h4>
            <p class="mt-1 flex items-center gap-1 text-xs font-medium text-black">
                {{ Number::currency($order->total_amount, in: 'XOF', locale: 'fr') }}
            </p>
        </div>
    </div>

    <div class="mt-3 rounded-lg text-gray-500 p-4 -mx-2 bg-white cursor-pointer">
        @if ($showCustomerDetails)
            <div class="space-y-1 mb-5 border-b border-gray-200 pb-5">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z">
                        </path>
                    </svg>
                    <span>{{ $order->customer?->fullname ?? '-' }}</span>
                </div>
                <div class="text-xs text-gray-500 ml-6">
                    {{ $order->customer?->email ?? '-' }}
                </div>
                <div class="text-xs text-gray-500 ml-6">
                    {{ $order->customer?->phone_number ?? '-' }}
                </div>
            </div>
        @endif

        <div class="space-y-4">
            @forelse ($order->products as $item)
                <div class="flex space-x-4 sm:min-w-0 sm:flex-1">
                    <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/order-history-page-07-product-01.jpg"
                        alt="Brass puzzle in the shape of a jack with overlapping rounded posts."
                        class="size-14 flex-none rounded-md object-cover sm:size-16">
                    <div class="min-w-0 flex-1 pt-1.5 sm:pt-0">
                        <h3 class="text-sm text-gray-500">
                            <a href="#">{{ $item->name }}</a> x {{ $item->pivot->quantity }}
                        </h3>
                        <p class="mt-1 text-xs font-medium text-black">
                            {{ Number::currency($item->pivot->total_price, in: 'XOF', locale: 'fr') }}
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
