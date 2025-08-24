@props(['customer', 'modalId' => 'show-customer-orders'])

<x-ui.modals.base :id="$modalId" size="xl">
    <x-slot:title>
        @if ($customer)
            {{ __('Commandes de') }} {{ $customer->fullname }}
        @else
            {{ __('Commandes du client') }}
        @endif
    </x-slot:title>

    @if ($customer)
        <!-- Liste des commandes -->
        <div>
            @if ($customer->orders->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($customer->orders as $order)
                        <x-ui.cards.order-card :order="$order" :showCustomerDetails="false" />
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Aucune commande') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __("Ce client n'a pas encore passé de commande.") }}</p>
                </div>
            @endif
        </div>
    @else
        <div class="text-center text-gray-500 py-8">
            <p class="text-sm text-gray-500">{{ __('Aucun client sélectionné.') }}</p>
        </div>
    @endif
</x-ui.modals.base>
