@extends('layouts.app')

@section('title', 'Sira - Votre gestion tout en un')

@section('content')
    <main>
        @include('partials.hero')

        @include('partials.primary-features')

        @include('partials.secondary-features')

        @include('partials.call-to-action')

        @include('partials.testimonials')

        @include('partials.pricing')

        @include('partials.faqs')
    </main>
@endsection
