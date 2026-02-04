@section('title', __('Dépenses'))

<div class="space-y-6" x-data="{
    init() {
        Livewire.on('expense-created', () => {
            $wire.$refresh()
        });
        Livewire.on('expense-updated', () => {
            $wire.$refresh()
        })
    }
}">
    <div class="flex items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Dépenses') }}
        </h1>

        <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'create-expense' })">
            {{ __('Ajouter une dépense') }}
        </x-ui.btn.primary>
    </div>

    <p class="text-sm overflow-hidden break-words text-gray-500 mt-1">
        Gérez et visualisez vos dépenses et charges fixes.
    </p>

    <!-- Recherche -->
    <div class="relative">
        <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
            <svg class="fill-gray-500" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                    fill=""></path>
            </svg>
        </span>
        <input type="text" wire:model.live.debounce.400ms="search" placeholder="Rechercher une dépense ..."
            class="shadow-xs focus:border-brand-300 focus:ring-gray-500/10 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-1 focus:outline-hidden xl:w-[430px]">
    </div>

    <!-- Modal de création d'entrepôt -->
    <x-ui.modals.create-expense-modal :tenant="$tenant" />

    <!-- Liste des entrepôts -->
    <div class="mt-8 flow-root">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm outline-1 outline-black/5 sm:rounded-lg">
                    <table class="relative min-w-full divide-y divide-gray-300">
                        <thead class="border-gray-100 border-y bg-gray-100">
                            <x-ui.tables.row>
                                <x-ui.tables.heading>
                                    <span class="font-medium text-gray-500 text-xs">
                                        {{ __('ID') }}
                                    </span>
                                </x-ui.tables.heading>

                                <x-ui.tables.heading>
                                    <span class="font-medium text-gray-500 text-xs">
                                        {{ __('Nom') }}
                                    </span>
                                </x-ui.tables.heading>

                                <x-ui.tables.heading>
                                    <span class="font-medium text-gray-500 text-xs">
                                        {{ __('Montant') }}
                                    </span>
                                </x-ui.tables.heading>

                                <x-ui.tables.heading>
                                    <span class="font-medium text-gray-500 text-xs">
                                        {{ __('Catégorie') }}
                                    </span>
                                </x-ui.tables.heading>

                                <x-ui.tables.heading>
                                    <span class="font-medium text-gray-500 text-xs">
                                        {{ __('Date') }}
                                    </span>
                                </x-ui.tables.heading>

                                <x-ui.tables.heading>
                                    <span class="font-medium text-gray-500 text-xs">
                                        Action
                                    </span>
                                </x-ui.tables.heading>
                            </x-ui.tables.row>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($expenses as $expense)
                                <x-ui.tables.row class="hover:bg-gray-50">
                                    <x-ui.tables.cell>
                                        <span class="font-medium text-gray-700 text-sm">
                                            #{{ $expense->id }}
                                        </span>
                                    </x-ui.tables.cell>

                                    <x-ui.tables.cell>
                                        <span class="text-gray-700 text-sm">
                                            {{ $expense->name }}
                                        </span>
                                    </x-ui.tables.cell>

                                    <x-ui.tables.cell>
                                        <span class="text-gray-700 text-sm">
                                            {{ Number::currency($expense->amount, in: 'XOF', locale: 'fr') }}
                                        </span>
                                    </x-ui.tables.cell>

                                    <x-ui.tables.cell>
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            {{ $expense->category }}
                                        </span>
                                    </x-ui.tables.cell>

                                    <x-ui.tables.cell>
                                        <span class="text-gray-700 text-sm">
                                            {{ $expense->spent_at->locale('fr')->format('d/m/Y') }}
                                        </span>
                                    </x-ui.tables.cell>

                                    <x-ui.tables.cell>
                                        <div class="flex items-center gap-2">
                                            <button type="button" wire:click="edit({{ $expense->id }})"
                                                class="flex items-center gap-1 text-blue-600 text-sm font-medium p-1 cursor-pointer">
                                                <svg class="size-5 text-blue/50 shrink-0" data-slot="icon" fill="none"
                                                    stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </x-ui.tables.cell>
                                </x-ui.tables.row>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-400 py-8">
                                        Aucune dépense trouvée.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <livewire:dashboard.settings.expenses.edit />
        </div>
    </div>
</div>