@section('title', 'Mouvements de caisse')

<div class="space-y-5" x-data="{
    init() {
        Livewire.on('transaction-updated', () => {
            $wire.$refresh()
        })
    }
}">
    <x-ui.breadcrumb :items="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard.index', ['tenant' => $tenant->slug])],
        ['label' => 'Mouvements de caisse', 'url' => '#'],
    ]" />

    <h1 class="text-2xl font-bold text-black">
        {{ __('Mouvements de caisse') }}
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <x-ui.cards.trending-stat label="Total entrées" :value="Number::currency($totalCashIn, in: 'XOF', locale: 'fr')">
            <x-slot:icon>
                <svg class="size-5 text-green-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat label="Total sorties" :value="Number::currency($totalCashOut, in: 'XOF', locale: 'fr')">
            <x-slot:icon>
                <svg class="size-5 text-red-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>

        <x-ui.cards.trending-stat label="Solde" :value="Number::currency($cashBalance, in: 'XOF', locale: 'fr')">
            <x-slot:icon>
                <svg class="size-5 text-blue-500" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                    </path>
                </svg>
                </x-slot>
        </x-ui.cards.trending-stat>
    </div>

    <!-- Search and filters -->
    <div class="space-y-4">
        <div class="lg:flex lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div class="relative">
                <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
                    <svg class="fill-gray-500" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                            fill=""></path>
                    </svg>
                </span>
                <input type="text" wire:model.live.debounce.400ms="search" placeholder="Rechercher une transaction ..."
                    class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 placeholder:text-sm focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm shadow-xs focus:border-brand-300 h-10 bg-transparent pr-14 pl-12 focus:outline-hidden xl:w-[430px]">
            </div>

            <div class="flex items-center gap-2">
                <x-ui.btn.primary type="button" :icon="false" wire:click="$set('typeFilter', 'all')">
                    {{ __('Tout') }}
                </x-ui.btn.primary>

                <x-ui.btn.primary type="button" :icon="false"
                    class="bg-green-600 hover:bg-green-500 border-green-600 text-white"
                    wire:click="$set('typeFilter', 'in')">
                    {{ __('Entrées') }}
                </x-ui.btn.primary>

                <x-ui.btn.primary type="button" :icon="false"
                    class="bg-red-600 hover:bg-red-500 border-red-600 text-white"
                    wire:click="$set('typeFilter', 'out')">
                    {{ __('Sorties') }}
                </x-ui.btn.primary>
            </div>
        </div>

        <!-- Date Filters -->
        <div class="lg:flex lg:items-center gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700">Période :</span>
                    <select wire:model.live="period"
                        class="block w-40 rounded-md border-gray-300 py-1 text-sm focus:border-black focus:ring-black">
                        <option value="this_month">Ce mois</option>
                        <option value="last_month">Mois dernier</option>
                        <option value="this_year">Cette année</option>
                        <option value="custom">Personnalisé</option>
                    </select>
                </div>

                <div class="mt-2 lg:mt-0 ml-auto text-xs text-gray-500">
                    @if($period === 'this_month')
                        <span class="text-gray-900">1er - {{ now()->endOfMonth()->format('d M') }}</span>
                    @elseif($period === 'this_year')
                        <span class="text-gray-900">Année {{ now()->year }}</span>
                    @endif
                </div>
            </div>

            <div class="mt-2 lg:mt-0 flex items-center gap-2" x-show="$wire.period === 'custom'" x-transition>
                <input type="date" wire:model.live="dateStart"
                    class="block rounded-md border-gray-300 py-1.5 text-xs focus:border-black focus:ring-black">
                <span class="text-gray-500">au</span>
                <input type="date" wire:model.live="dateEnd"
                    class="block rounded-md border-gray-300 py-1.5 text-xs focus:border-black focus:ring-black">
            </div>
        </div>
    </div>

    <div class="mt-8 flow-root px-4 lg:px-0">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden shadow-sm outline-1 outline-black/5 border border-black/10 lg:border-0 rounded-lg">
                    <table class="relative min-w-full divide-y divide-gray-300">
                        <thead class="border-gray-100 border-y bg-gray-100">
                            <x-ui.tables.row>
                                <x-ui.tables.heading sortable direction="asc"
                                    wire:click.prevent="sortBy('spent_at', '{{ $sortDirection === 'asc' ? 'desc' : 'asc' }}')">
                                    <span class="font-medium text-gray-500 text-xs">
                                        {{ __('Date') }}
                                    </span>
                                </x-ui.tables.heading>

                                <x-ui.tables.heading>
                                    <span class="font-medium text-gray-500 text-xs">
                                        {{ __('Description') }}
                                    </span>
                                </x-ui.tables.heading>

                                <x-ui.tables.heading>
                                    <span class="font-medium text-gray-500 text-xs">
                                        {{ __('Catégorie') }}
                                    </span>
                                </x-ui.tables.heading>

                                <x-ui.tables.heading align="right">
                                    <span class="font-medium text-gray-500 text-xs text-right">
                                        {{ __('Montant') }}
                                    </span>
                                </x-ui.tables.heading>
                            </x-ui.tables.row>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($transactions as $transaction)
                                <x-ui.tables.row class="hover:bg-gray-50">
                                    <x-ui.tables.cell>
                                        <span class="text-gray-700 text-sm">
                                            {{ $transaction->date->format('d M. Y') }}
                                        </span>
                                    </x-ui.tables.cell>

                                    <x-ui.tables.cell>
                                        <span class="inline-flex items-center gap-2 text-gray-700 text-sm">
                                            @if ($transaction->type === 'in')
                                                <div
                                                    class="w-6 h-6 rounded flex items-center justify-center flex-shrink-0 bg-green-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="w-3 h-3 text-green-500">
                                                        <path d="M7 7h10v10"></path>
                                                        <path d="M7 17 17 7"></path>
                                                    </svg>
                                                </div>
                                            @elseif ($transaction->type === 'out')
                                                <div
                                                    class="w-6 h-6 rounded flex items-center justify-center flex-shrink-0 bg-red-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="w-3 h-3 text-red-500">
                                                        <path d="m7 7 10 10"></path>
                                                        <path d="M17 7v10H7"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            {{ $transaction->label }}
                                        </span>
                                    </x-ui.tables.cell>

                                    <x-ui.tables.cell>
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            {{ $transaction->category }}
                                        </span>
                                    </x-ui.tables.cell>

                                    <x-ui.tables.cell class="text-right">
                                        <span
                                            class="text-gray-700 text-sm {{ $transaction->type === 'out' ? 'text-red-500' : 'text-green-500' }}">
                                            {{ Number::currency($transaction->amount, in: 'XOF', locale: 'fr') }}
                                        </span>
                                    </x-ui.tables.cell>
                                </x-ui.tables.row>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-400 py-8">
                                        Aucune transaction trouvée.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- {{ $transactions->links() }} --}}
        </div>
    </div>
</div>