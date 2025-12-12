<header class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="relative z-50 flex justify-between">
            <div class="flex items-center md:gap-x-12">
                <a aria-label="Home" href="#">
                    <x-logo class="h-12 w-auto shrink-0" />
                </a>

                <div class="hidden md:flex md:gap-x-6">
                    <a class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                        href="#features">
                        Fonctionnalités
                    </a>
                    <a class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                        href="#testimonials">
                        Témoignages
                    </a>
                    <a class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900"
                        href="#pricing">
                        Tarifs
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-x-5 md:gap-x-8">
                @guest
                    <div class="hidden md:block">
                        <a href="{{ route('auth.login') }}"
                            class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                            Connexion
                        </a>
                    </div>
                @endguest

                @auth
                    <a href="{{ route('dashboard.index', ['tenant' => current_tenant()]) }}"
                        class="group inline-flex items-center justify-center rounded-full py-2 px-6 text-sm font-semibold focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"
                        color="blue" variant="solid">
                        <span>Tableau de bord</span>
                    </a>
                @else
                    <a href="{{ route('auth.register') }}"
                        class="group inline-flex items-center justify-center rounded-full py-2 px-6 text-sm font-semibold focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"
                        color="blue" variant="solid">
                        <span>Rejoignez-nous <span class="hidden lg:inline">today</span></span>
                    </a>
                @endauth

                <div class="-mr-1 md:hidden">
                    <div data-headlessui-state="" x-data="{ openMenu: false }">
                        <button @click="openMenu = !openMenu"
                            class="relative z-10 flex h-8 w-8 items-center justify-center focus:not-data-focus:outline-hidden"
                            aria-label="Toggle Navigation" type="button" aria-expanded="false">
                            <svg x-show="!openMenu" data-slot="icon" fill="none" stroke-width="1.5"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5"></path>
                            </svg>
                            <svg x-show="openMenu" aria-hidden="true" class="h-5 w-5 overflow-visible stroke-slate-700"
                                fill="none" stroke-width="2" stroke-linecap="round">
                                <path d="M0 1H14M0 7H14M0 13H14" class="origin-center transition scale-90 opacity-0">
                                </path>
                                <path d="M2 2L12 12M12 2L2 12" class="origin-center transition"></path>
                            </svg>
                        </button>

                        {{-- <div x-show="openMenu"
                            class="fixed inset-0 bg-slate-300/50 duration-150 data-closed:opacity-0 data-enter:ease-out data-leave:ease-in"
                            aria-hidden="true"></div> --}}

                        <div x-show="openMenu"
                            class="absolute inset-x-0 top-full mt-4 flex origin-top flex-col rounded-2xl bg-white p-4 text-lg tracking-tight text-slate-900 shadow-xl ring-1 ring-slate-900/5 data-closed:scale-95 data-closed:opacity-0 data-enter:duration-150 data-enter:ease-out data-leave:duration-100 data-leave:ease-in"
                            tabindex="-1" style="--button-width: 32px;">
                            <a class="block w-full p-2" href="#features" @click="openMenu = false">
                                Fonctionnalités
                            </a>
                            <a class="block w-full p-2" href="#testimonials" @click="openMenu = false">
                                Témoignages
                            </a>
                            <a class="block w-full p-2" href="#pricing" @click="openMenu = false">
                                Tarifs
                            </a>

                            <hr class="m-2 border-slate-300/40">

                            @auth
                                <a href="{{ route('dashboard.index', ['tenant' => current_tenant()]) }}"
                                    class="inline-flex items-center justify-center rounded-full py-2 px-6 text-sm font-semibold focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600">
                                    <span>Tableau de bord</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>