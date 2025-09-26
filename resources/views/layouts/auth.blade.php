@extends('layouts.base')

@section('body')
    <div class="min-h-screen">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
@endsection
