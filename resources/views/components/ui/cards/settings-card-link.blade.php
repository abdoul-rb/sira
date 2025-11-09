@props(['routeName', 'title', 'description'])

<a href="{{ route($routeName, ['tenant' => $currentTenant]) }}"
    class="flex items-start space-x-3 rounded-lg p-3 transition duration-200 ease-in-out hover:bg-gray-100 {{ request()->routeIs($routeName) ? 'bg-gray-100' : '' }}"
    wire:navigate.hover>

    <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white">
        {{ $icon }}
    </div>

    <div class="">
        <p class="inline-flex items-center font-medium text-black">
            {{ __($title) }}
        </p>
        <p class="text-xs leading-4 text-gray-500">
            {{ __($description) }}
        </p>
    </div>
</a>
