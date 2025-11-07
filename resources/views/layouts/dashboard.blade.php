@extends('layouts.base')

@section('body')
    <div x-data="{ open: false }" @keydown.window.escape="open = false">
        <!-- MOBILE -->
        @include('partials.dashboard.__mobile-menu')

        <div>
            @include('partials.dashboard.__header-menu')

            <main class="pt-8 pb-24 bg-gray-50 min-h-screen">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    @yield('content')

                    @isset($slot)
                        {{ $slot }}
                    @endisset
                </div>
            </main>
        </div>
    </div>
@endsection
