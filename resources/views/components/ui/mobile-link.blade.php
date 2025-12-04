@props(['label', 'route', 'active' => false])

<a class="inline-flex flex-col items-center justify-center p-2 rounded-xl {{ $active ? 'text-black' : 'text-gray-400' }}"
    href="{{ $route }}">
    <div class="p-2 rounded-lg transition-all duration-300 {{ $active ? 'bg-black text-white' : 'text-gray-400' }}">
        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
    <span class="text-xs tracking-wide {{ $active ? 'mt-1 text-black' : 'text-gray-400' }}">
        {{ $label }}
    </span>
</a>