@section('title', __('Employés'))

<div>
    <x-ui.breadcrumb :items="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard.index', ['tenant' => $tenant])],
        ['label' => 'Employés', 'url' => '#'],
    ]" />

    <div class="flex items-center justify-between mt-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Employés</h1>

        {{-- @can('create', App\Models\Employee::class) --}}
        <a href="{{ route('dashboard.employees.create', ['tenant' => $tenant]) }}"
            class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-blue-600 px-3 py-2 lg:py-1 text-sm text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
            <svg class="size-4 transition duration-75 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
            </svg>
            {{ __('Nouvel employé') }}
        </a>
        {{-- @endcan --}}
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L9.53 11.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filtres et recherche -->
    <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl mb-6">
        <div class="px-4 py-6 sm:p-8">
            <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="search" class="block text-sm font-medium text-gray-700">Recherche</label>
                    <div class="mt-1">
                        <input type="text" wire:model.live.debounce.300ms="search" id="search"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                    <div class="mt-1">
                        <select wire:model.live="status" id="status"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6">
                            <option value="">Tous les employés</option>
                            <option value="connected">Avec accès</option>
                            <option value="offline">Sans accès</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-1">
                    <label for="sort" class="block text-sm font-medium text-gray-700">Tri</label>
                    <div class="mt-1">
                        <select wire:model.live="sortField" id="sort"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6">
                            <option value="created_at">Date création</option>
                            <option value="position">Poste</option>
                            <option value="department">Département</option>
                            <option value="hire_date">Date embauche</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul role="list" class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($employees as $employee)
            <x-ui.cards.employee-details :employee="$employee" />
        @empty
            <li>
                <p class="text-center text-gray-500">Aucun employé trouvé.</p>
            </li>
        @endforelse
    </ul>
</div>
