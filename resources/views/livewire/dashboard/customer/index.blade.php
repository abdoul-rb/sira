@section('title', __('Liste des clients'))

<div>
    <x-ui.breadcrumb :items="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard.index', ['tenant' => $tenant->slug])],
        ['label' => 'Clients', 'url' => route('dashboard.customers.index', ['tenant' => $tenant->slug])],
    ]" />

    <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Clients') }}
        </h1>

        <a href="{{ route('dashboard.customers.create', ['tenant' => $tenant->slug]) }}"
            class="inline-flex items-center gap-x-1.5 rounded-md bg-blue-600 px-3 py-1 text-sm text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
            <svg class="size-4 transition duration-75 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
            </svg>
            {{ __('Ajouter un client') }}
        </a>
    </div>

    <div class="mt-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="w-full md:w-1/2">
                <!-- Recherche globale -->
                <div class="relative">
                    <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
                        <svg class="fill-gray-500 " width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                                fill=""></path>
                        </svg>
                    </span>
                    <input type="text" wire:model.debounce.400ms="search" placeholder="Recherche globale..."
                        class="shadow-xs focus:border-brand-300 focus:ring-gray-500/10 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-1 focus:outline-hidden xl:w-[430px]">
                </div>
            </div>
            <div class="flex gap-2 items-center">
                <!-- Filtre par type -->
                <select wire:model="type" class="rounded-md border-gray-300 text-sm focus:ring-teal-600">
                    <option value="">Tous les types</option>
                    @foreach ($types as $enum)
                        <option value="{{ $enum->value }}">{{ $enum->label() }}</option>
                    @endforeach
                </select>
                <!-- Tri -->
                <select wire:model="sortField" class="rounded-md border-gray-300 text-sm focus:ring-teal-600">
                    <option value="lastname">Nom</option>
                    <option value="created_at">Date d'ajout</option>
                </select>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-md px-4 py-2">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($customers as $customer)
                <x-ui.cards.customer-details :customer="$customer" :confirmingDelete="$confirmingDelete" />
            @empty
                <div class="col-span-full text-center text-gray-500 py-10">Aucun client trouvé.</div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $customers->links() }}
        </div>
    </div>

</div>
