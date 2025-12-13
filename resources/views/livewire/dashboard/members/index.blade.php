@section('title', __('Membres'))

<div x-data="{
    init() {
        Livewire.on('member-created', () => {
            $wire.$refresh()
        });
        Livewire.on('member-updated', () => {
            $wire.$refresh()
        })
    }
}">
    {{-- <x-ui.breadcrumb :items="[
        ['label' => 'Paramètres', 'url' => route('dashboard.settings.index', ['tenant' => $tenant])],
        ['label' => 'Membres', 'url' => '#'],
    ]" /> --}}

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Membres / Employés</h1>

        @can('create-member')
            <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'create-member' })">
                {{ __('Ajouter un membre') }}
            </x-ui.btn.primary>
        @endcan
    </div>

    <x-ui.modals.create-member-modal :tenant="$tenant" />

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

                <div class="sm:col-span-1">
                    <label for="sort" class="block text-sm font-medium text-gray-700">Tri</label>
                    <div class="mt-1">
                        <select wire:model.live="sortField" id="sort"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6">
                            <option value="created_at">Date d'ajout</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul role="list" class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2">
        @forelse ($members as $member)
            <x-ui.cards.member-details :member="$member" />
        @empty
            <li>
                <p class="text-center text-gray-500">Aucun employé trouvé.</p>
            </li>
        @endforelse
    </ul>
</div>