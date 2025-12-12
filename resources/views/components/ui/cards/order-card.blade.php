@props(['order', 'showCustomerDetails' => true])

<div class="bg-gray-100 border border-gray-200 rounded-lg p-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium text-gray-900 md:shrink-0">
            Vente #{{ strtoupper($order->order_number) }}
        </h2>

        <div>
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
                    @can('create-product')
                        <a href="{{ route('dashboard.orders.edit', ['tenant' => current_tenant(), 'order' => $order]) }}"
                            class="block w-full block px-3 py-1 text-xs font-medium leading-6 text-gray-900 hover:bg-gray-50 text-left cursor-pointer">
                            Modifer
                            <span class="sr-only">, {{ $order->order_number }}</span>
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.orders.invoice', ['tenant' => current_tenant(), 'order' => $order]) }}"
                        target="_blank"
                        class="flex items-center gap-x-1 w-full px-3 py-1 text-xs font-medium leading-6 text-gray-900 hover:bg-gray-50 text-left cursor-pointer outline-none transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4">
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"></path>
                            <rect x="6" y="14" width="12" height="8" rx="1"></rect>
                        </svg>
                        Imprimer la facture
                    </a>
                </x-slot>
            </x-ui.dropdown>
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
                {{ Number::currency($order->total_amount, in: 'XOF', locale: 'fr') }}
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
            @forelse ($order->productLines as $item)
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