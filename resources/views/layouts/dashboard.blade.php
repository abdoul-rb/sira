@extends('layouts.base')

@section('body')
    <div x-data="{ open: false }" @keydown.window.escape="open = false">
        <!-- MOBILE -->
        <div x-show="open" class="relative z-50 lg:hidden" x-ref="dialog" aria-modal="true" style="display: none;">
            <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80" style="display: none;"></div>

            <div class="fixed inset-0 flex">
                <div x-show="open" class="relative mr-16 flex w-full max-w-xs flex-1" @click.away="open = false"
                    x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                    style="display: none;">
                    <div x-show="open" class="absolute left-full top-0 flex w-16 justify-center pt-5"
                        x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                        <button type="button" class="-m-2.5 p-2.5" @click="open = false">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-100 px-6 pb-4 ring-1 ring-white/10">
                        <div class="flex h-16 shrink-0 items-center">
                            <img class="h-8 w-auto"
                                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&amp;shade=500"
                                alt="Your Company">
                        </div>

                        @include('partials.dashboard.__menu')
                    </div>
                </div>
            </div>
        </div>

        <!-- Static sidebar for DESKTOP -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col border-r border-gray-200">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&amp;shade=500"
                        alt="Your Company">
                </div>

                @include('partials.dashboard.__menu')
            </div>
        </div>

        <div class="lg:pl-72">
            @include('partials.dashboard.__header')

            <main class="py-10 px-6 bg-gray-50 min-h-screen">
                @yield('content')
            </main>
        </div>
    </div>
@endsection
