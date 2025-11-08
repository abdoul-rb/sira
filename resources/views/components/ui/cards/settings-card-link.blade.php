@props(['route', 'title', 'description'])

<a href="{{ $route }}"
    class="flex items-start space-x-4 rounded-lg p-3 transition duration-200 ease-in-out hover:bg-gray-100"
    wire:navigate.hover>

    <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white">
        {{ $icon }}
    </div>

    <div class="space-y-1">
        <p class="inline-flex items-center font-medium text-black">
            {{ __($title) }}
        </p>
        <p class="text-sm leading-5 text-gray-500">
            {{ __($description) }}
        </p>
    </div>
</a>
