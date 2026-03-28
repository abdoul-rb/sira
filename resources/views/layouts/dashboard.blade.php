@extends('layouts.base')

@section('body')
    <div x-data="{ open: false }" @keydown.window.escape="open = false">
        <!-- MOBILE -->
        @if(auth()->user()->member?->company_id && !request()->routeIs('dashboard.onboarding'))
            @include('partials.dashboard.__mobile-menu')
        @endif

        <div>
            @if(auth()->user()->member?->company_id && !request()->routeIs('dashboard.onboarding'))
                @include('partials.dashboard.__header-menu')
            @endif

            <main class="pt-8 pb-24 bg-gray-50 min-h-screen">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-4 xl:px-0">
                    @yield('content')

                    @isset($slot)
                        {{ $slot }}
                    @endisset

                    <x-ui.notify />
                </div>
            </main>
        </div>
    </div>
@endsection