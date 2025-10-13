@extends('layouts.base')

@section('body')
    @include('partials.__header')

    @yield('content')

    @isset($slot)
        {{ $slot }}
    @endisset

    @include('partials.__footer')
@endsection
