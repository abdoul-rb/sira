@section('title', 'Créances')

<div class="space-y-5" x-data="{
    init() {
        Livewire.on('order-updated', () => {
            $wire.$refresh()
        })
    }
}">
    <div>
        <h1 class="text-2xl font-bold text-black">
            {{ __('Créances') }}
        </h1>
        <p class="text-gray-500 text-sm">Suivi des impayés clients</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <x-ui.cards.trending-stat label="Nombre de créances" :value="$creditsOrdersCount">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat label="Total en attente" :value="Number::currency($totalCredits, in: 'XOF', locale: 'fr')">
            <x-slot:icon>
                <svg class="size-6 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>
    </div>

    <!-- Filters -->

    <div class="col-span-full">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4">
            <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        Créances
                    </h3>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <form>
                        <div class="relative">
                            <span class="absolute -translate-y-1/2 pointer-events-none top-1/2 left-4">
                                <svg class="fill-gray-500 size-4" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                        fill=""></path>
                                </svg>
                            </span>
                            <input type="text" placeholder="Rechercher par numéro de commande ..."
                                wire:model.live.debounce.400ms="search"
                                class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm   shadow-xs focus:border-brand-300 h-10 pr-14 pl-10 focus:outline-hidden xl:w-[430px]">
                        </div>
                    </form>
                </div>
            </div>

            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="min-w-full">
                    <!-- table header start -->
                    <thead class="border-gray-100 border-y bg-gray-50">
                        <x-ui.tables.row>
                            <x-ui.tables.heading>
                                <div x-data="{ checked: false }" class="flex items-center gap-3">
                                    <div @click="checked = !checked"
                                        class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px] bg-white /0 border-gray-300 "
                                        :class="checked ? 'border-brand-500  bg-brand-500' :
                                            'bg-white /0 border-gray-300 '">
                                        <svg :class="checked ? 'block' : 'hidden'" width="14" height="14"
                                            viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                                            class="hidden">
                                            <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white"
                                                stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="block font-medium text-gray-500 text-xs">
                                        N°
                                    </span>
                                </div>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Client') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Montant total') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Reste à payer') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Date de commande') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    {{ __('Statut') }}
                                </span>
                            </x-ui.tables.heading>

                            <x-ui.tables.heading>
                                <span class="font-medium text-gray-500 text-xs">
                                    Action
                                </span>
                            </x-ui.tables.heading>
                        </x-ui.tables.row>
                    </thead>
                    <!-- table header end -->

                    <!-- table body start -->
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <x-ui.tables.row class="hover:bg-gray-50">
                                <x-ui.tables.cell>
                                    <div x-data="{ checked: false }" class="flex items-center gap-3">
                                        <div @click="checked = !checked"
                                            class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px] bg-white /0 border-gray-300 "
                                            :class="checked ? 'border-brand-500  bg-brand-500' : 'bg-white /0 border-gray-300 '">
                                            <svg :class="checked ? 'block' : 'hidden'" width="14" height="14"
                                                viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                class="hidden">
                                                <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white"
                                                    stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="block font-medium text-gray-700 text-sm">
                                            {{ $order->order_number }}
                                        </span>
                                    </div>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-50">
                                            <span class="text-xs font-semibold text-blue-500">
                                                {{ $order->customer?->initials ?? '-' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-sm block font-medium text-gray-700">
                                                {{ $order->customer?->fullname ?? '-' }}
                                            </span>
                                            <span class="text-gray-500 text-xs">
                                                {{ $order->customer?->email ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <span class="text-gray-700 text-sm">
                                        {{ Number::currency($order->total_amount, in: 'XOF', locale: 'fr') }}
                                    </span>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <span class="text-gray-700 text-sm">
                                        {{ Number::currency($order->remaining_amount, in: 'XOF', locale: 'fr') }}
                                    </span>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <span class="text-gray-700 text-sm">
                                        {{ $order->created_at->format('d M. Y') }}
                                    </span>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <span class="{{ $order->payment_status->color() }} text-xs rounded-full px-2 py-0.5">
                                        {{ $order->payment_status->label() }}
                                    </span>
                                </x-ui.tables.cell>

                                <x-ui.tables.cell>
                                    <div class="flex items-center gap-2">
                                        <x-ui.btn.transparent type="button" class="!py-1.5"
                                            wire:click="markAsPaid({{ $order->id }})">
                                            {{ __('Marquer comme payé') }}
                                        </x-ui.btn.transparent>
                                    </div>
                                </x-ui.tables.cell>
                            </x-ui.tables.row>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400 py-8">
                                    Aucune commande trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <!-- table body end -->
                </table>
            </div>
        </div>
        <!-- Table Four -->
    </div>
</div>