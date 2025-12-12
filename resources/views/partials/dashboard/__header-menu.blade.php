<nav class="sticky top-0 z-40 border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-4 xl:px-0">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <x-logo class="h-16 w-auto shrink-0" />
                </div>
                <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('dashboard.index') }}" aria-current="page"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 {{ request()->routeIs('dashboard.index') ? 'border-indigo-600 text-gray-900' : 'border-transparent' }}">
                        {{ __('Tableau de bord') }}
                    </a>

                    <a href="{{ route('dashboard.products.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 {{ request()->routeIs('dashboard.products.*') ? 'border-indigo-600 text-gray-900' : 'border-transparent' }}">
                        {{ __('Stock') }}
                    </a>

                    <a href="{{ route('dashboard.expenses.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 {{ request()->routeIs('dashboard.expenses.*') ? 'border-indigo-600 text-gray-900' : 'border-transparent' }}">
                        {{ __('Dépenses') }}
                    </a>

                    <a href="{{ route('dashboard.orders.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 {{ request()->routeIs('dashboard.orders.*') ? 'border-indigo-600 text-gray-900' : 'border-transparent' }}">
                        {{ __('Ventes') }}
                    </a>

                    <a href="{{ route('dashboard.customers.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 {{ request()->routeIs('dashboard.customers.*') ? 'border-indigo-600 text-gray-900' : 'border-transparent' }}">
                        {{ __('Clients') }}
                    </a>
                </div>
            </div>

            <div class="sm:ml-6 flex items-center">
                <button type="button"
                    class="relative rounded-full p-1 text-gray-400 hover:text-gray-500 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600">
                    <span class="absolute -inset-1.5"></span>
                    <span class="sr-only">View notifications</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="size-6">
                        <path
                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                            stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </button>

                <!-- Profile dropdown -->
                <div class="relative ml-3" style="--button-width: 32px;" x-data="{ dropdownOpen: false }"
                    @click.outside="dropdownOpen = false">
                    <button x-ref="button" x-on:click="dropdownOpen = !dropdownOpen" :aria-expanded="dropdownOpen"
                        type="button"
                        class="relative flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer"
                        id="menu-button-1" aria-haspopup="menu" aria-controls="menu-0" aria-expanded="false"
                        popovertarget="menu-0">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Open user menu</span>
                        <div class="size-10 shrink-0 rounded-full bg-black flex items-center justify-center">
                            <span class="text-sm font-medium text-white">
                                {{ auth()->user()->initials }}
                            </span>
                        </div>

                        {{-- <img
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                            alt="" class="size-8 rounded-full outline -outline-offset-1 outline-black/5"> --}}
                    </button>

                    <div x-ref="panel" x-show="dropdownOpen" x-on:click.outside="dropdownOpen = false"
                        class="w-48 absolute top-10 right-0 rounded-md bg-white py-1 shadow-lg outline outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-75 data-leave:ease-in"
                        id="menu-0" aria-labelledby="menu-button-1" role="menu">
                        <a href="{{ route('dashboard.profile.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 hover:bg-gray-50 focus:outline-hidden"
                            id="item-1" role="menuitem" tabindex="-1">
                            Profil
                        </a>
                        <a href="{{ route('dashboard.settings.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 hover:bg-gray-50 focus:outline-hidden"
                            id="item-2" role="menuitem" tabindex="-1">
                            Paramètres
                        </a>
                        <div class="inline-block w-full px-0 py-0 text-sm text-gray-700 hover:bg-gray-50">
                            <a href="{{ route('logout') }}"
                                class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 hover:bg-gray-50 focus:outline-hidden"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="-mr-2 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button type="button" command="--toggle" commandfor="mobile-menu"
                    class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-600"
                    aria-expanded="false" aria-controls="mobile-menu">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open
                        main menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                            stroke-linejoin="round">
                        </path>
                    </svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>
</nav>