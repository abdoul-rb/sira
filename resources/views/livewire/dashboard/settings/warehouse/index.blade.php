@section('title', __('Emplacements'))

<div class="space-y-6" x-data="{
    init() {
        Livewire.on('warehouse-created', () => {
            // Rafraîchir la liste des entrepôts
            $wire.$refresh()
        })
    }
}">
    <div class="flex items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Emplacements') }}
        </h1>

        <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'create-warehouse' })">
            {{ __('Ajouter un entrepôt') }}
        </x-ui.btn.primary>
    </div>

    <p class="text-sm overflow-hidden break-words text-gray-500 mt-1">
        Gérez les emplacements où vous stockez des marchandises.
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
        <input type="text" wire:model.live.debounce.400ms="search" placeholder="Rechercher un entrepôt ..."
            class="shadow-xs focus:border-brand-300 focus:ring-gray-500/10 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-1 focus:outline-hidden xl:w-[430px]">
    </div>

    <!-- Modal de création d'entrepôt -->
    <x-ui.modals.create-warehouse-modal :tenant="$tenant" />

    <!-- Liste des entrepôts -->
    <div class="mt-6 overflow-hidden border border-gray-200 rounded-lg shadow-2xs">
        <div class="mx-auto max-w-7xl px-0 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr class="py-2.5">
                            <th class="text-sm font-medium text-black py-3 px-4 lg:px-0">
                                Nom
                                <span class="sr-only">Localisation</span>
                            </th>
                            <th class="sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-t border-gray-200 divide-y divide-gray-200">
                        @forelse ($warehouses as $warehouse)
                            <tr>
                                <td class="py-5 px-4 lg:px-0">
                                    <div class="flex gap-x-6">
                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                            class="hidden h-6 w-5 flex-none text-gray-400 sm:block">
                                            <path
                                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-.75-4.75a.75.75 0 0 0 1.5 0V8.66l1.95 2.1a.75.75 0 1 0 1.1-1.02l-3.25-3.5a.75.75 0 0 0-1.1 0L6.2 9.74a.75.75 0 1 0 1.1 1.02l1.95-2.1v4.59Z"
                                                clip-rule="evenodd" fill-rule="evenodd" />
                                        </svg>
                                        <div class="flex-auto">
                                            <div class="flex items-start gap-x-3">
                                                <div class="text-sm/6 font-medium text-gray-900">
                                                    {{ $warehouse->name }}
                                                </div>
                                                @if ($warehouse->default)
                                                    <div
                                                        class="rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                        Par défaut
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-xs/5 text-gray-500">{{ $warehouse->location }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-5 px-4 lg:px-0">
                                    <div class="">
                                        <a href="#"
                                            class="text-sm/6 font-medium text-indigo-600 hover:text-indigo-500">
                                            Editer
                                        </a>
                                    </div>
                                    <div class="mt-1 text-xs/5 text-gray-500">
                                        Entrepôt
                                        <span class="text-gray-900">#00012</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-5">
                                    <p class="text-gray-500">Aucun entrepôt trouvé.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
