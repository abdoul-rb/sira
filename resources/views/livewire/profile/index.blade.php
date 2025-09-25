@extends('layouts.dashboard')

@section('title', __('Mon profil'))

@section('content')
    <div class="space-y-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-2xl font-bold text-black">
                {{ __('Mon profil') }}
            </h1>
        </div>

        <ul class="flex flex-col items-center gap-2">
            <li class="w-full">
                <a href="#"
                    class="group flex items-center gap-x-2 rounded-md bg-gray-200 px-4 py-2 text-xs font-medium text-black">
                    <svg class="size-5 shrink-0" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z">
                        </path>
                    </svg>
                    {{ __('Suivi des ventes') }}
                </a>
            </li>

        </ul>
    </div>
@endsection
