@section('title', __('Liste des clients'))

<div>
    <div class="flex items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-black">
            {{ __('Mes clients') }}
        </h1>

        <x-ui.btn.primary @click="$dispatch('open-modal', { id: 'add-customer' })">
            {{ __('Ajouter un client') }}
        </x-ui.btn.primary>
    </div>

    <x-ui.modals.add-customer-modal :tenant="$tenant" />

    <div class="mt-3 space-y-6">
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
                    <input type="text" wire:model.live.debounce.500ms="search"
                        placeholder="Rechercher par nom, email..."
                        class="shadow-xs focus:border-brand-300 focus:ring-gray-500/10 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-1 focus:outline-hidden xl:w-[430px]">
                </div>
            </div>

            {{-- <div class="flex gap-2 items-center">
                <!-- Filtre par type -->
                <div class="mt-2 lg:mt-0 flex items-center gap-2">
                    <div x-data="{
                        open: false,
                        toggle() {
                            if (this.open) { return this.close() }
                    
                            this.$refs.button.focus()
                            this.open = true
                        },
                        close(focusAfter) {
                            if (!this.open) return
                            this.open = false
                            focusAfter && focusAfter.focus()
                        }
                    }" x-on:keydown.escape.prevent.stop="close($refs.button)"
                        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                        x-id="['dropdown-button']" class="relative w-full col-span-full">

                        <!-- Button -->
                        <button x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                            :aria-controls="$id('dropdown-button')" type="button"
                            class="relative flex items-center justify-center lg:justify-between w-full gap-2 bg-white px-3 p-2.5 rounded-md ring-1 ring-inset ring-black/10 focus:ring-2 focus:ring-inset focus:ring-cyan-600 z-20 cursor-pointer">
                            <span class="text-sm truncate text-black">
                                {!! __('Type de client') !!}
                            </span>

                            <!-- Heroicon: chevron-down -->
                            <span>
                                <svg x-show="!open" class="size-4 text-dark/50 shrink-0" data-slot="icon" fill="none"
                                    stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5">
                                    </path>
                                </svg>

                                <svg x-show="open" class="size-4 text-dark/50 shrink-0 rotate-180" data-slot="icon"
                                    fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5">
                                    </path>
                                </svg>
                            </span>
                        </button>

                        <!-- Panel Desktop -->
                        <div x-ref="panel" x-show="open" x-transition.origin.top.left
                            x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')" style="display: none;"
                            class="mt-2 absolute right-0 w-40 rounded-lg bg-white ring-1 ring-gray-200 z-10">
                            <div class="divide-y divide-black/8 py-2">
                                @foreach ($types as $enum)
                                    <button type="button" wire:click.prevent="sortBy('type', 'desc')"
                                        x-on:click="close()"
                                        class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-3 text-left text-sm hover:bg-gray-100 disabled:text-black/50 cursor-pointer {{ $sortField === 'created_at' && $sortDirection === 'desc' ? 'bg-i-secondary/10 text-i-primary' : '' }}">
                                        {{ $enum->label() }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tri par -->
                <div class="mt-2 lg:mt-0 flex items-center gap-2">
                    <div x-data="{
                        open: false,
                        toggle() {
                            if (this.open) { return this.close() }
                    
                            this.$refs.button.focus()
                            this.open = true
                        },
                        close(focusAfter) {
                            if (!this.open) return
                            this.open = false
                            focusAfter && focusAfter.focus()
                        }
                    }" x-on:keydown.escape.prevent.stop="close($refs.button)"
                        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                        x-id="['dropdown-button']" class="relative w-full col-span-full">

                        <!-- Button -->
                        <button x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                            :aria-controls="$id('dropdown-button')" type="button"
                            class="relative flex items-center justify-center lg:justify-between w-full gap-2 bg-white px-3 p-2.5 rounded-md ring-1 ring-inset ring-black/10 focus:ring-2 focus:ring-inset focus:ring-cyan-600 z-20 cursor-pointer">
                            <span class="text-sm truncate text-black">
                                {!! __('Trier par') !!}
                            </span>

                            <!-- Heroicon: chevron-down -->
                            <span>
                                <svg x-show="!open" class="size-4 text-dark/50 shrink-0" data-slot="icon" fill="none"
                                    stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5">
                                    </path>
                                </svg>

                                <svg x-show="open" class="size-4 text-dark/50 shrink-0 rotate-180" data-slot="icon"
                                    fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5">
                                    </path>
                                </svg>
                            </span>
                        </button>

                        <!-- Panel Desktop -->
                        <div x-ref="panel" x-show="open" x-transition.origin.top.left
                            x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')"
                            style="display: none;"
                            class="mt-2 absolute right-0 w-40 rounded-lg bg-white ring-1 ring-gray-200 z-10">
                            <div class="divide-y divide-black/8 py-2">
                                <button type="button" wire:click.prevent="sortBy('firstname', 'desc')"
                                    x-on:click="close()"
                                    class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-3 text-left text-sm hover:bg-gray-100 disabled:text-black/50 cursor-pointer {{ $sortField === 'created_at' && $sortDirection === 'desc' ? 'bg-i-secondary/10 text-i-primary' : '' }}">
                                    Nom
                                </button>

                                <button type="button" wire:click.prevent="sortBy('created_at', 'desc')"
                                    x-on:click="close()"
                                    class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-3 text-left text-sm hover:bg-gray-100 disabled:text-black/50 cursor-pointer {{ $sortField === 'created_at' && $sortDirection === 'desc' ? 'bg-i-secondary/10 text-i-primary' : '' }}">
                                    {{ __("Date d'ajout") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-md px-4 py-2">
                {{ session('success') }}
            </div>
        @endif

        <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($customers as $customer)
                <x-ui.cards.customer-details :customer="$customer" />

                <!-- Modal pour afficher les commandes du client -->
                <x-ui.modals.show-customer-orders :customer="$customer" :modalId="'show-customer-orders-' . $customer->id" />
            @empty
                <div class="col-span-full text-center text-gray-500 py-10">Aucun client trouvé.</div>
            @endforelse
        </ul>

        <div class="mt-6">
            {{ $customers->links() }}
        </div>
    </div>
</div>
