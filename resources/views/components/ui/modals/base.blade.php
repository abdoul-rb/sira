@props(['id', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-7xl',
    ];

    $modalSize = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div x-data="{ open: false }" x-show="open" x-cloak
    @open-modal.window="
        if ($event.detail.id === '{{ $id }}') {
            open = true;
        }
    "
    @close-modal.window="
        if ($event.detail.id === '{{ $id }}') {
            open = false;
        }
    "
    @keydown.window.escape="open = false" @click.outside="open = false" class="fixed inset-0 z-50 overflow-y-auto">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div
            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 shadow-xl transition-all w-full {{ $modalSize }}">

            <!-- Bouton fermer -->
            <div class="absolute right-0 top-0 pr-4 pt-4">
                <button @click="$dispatch('close-modal', { id: '{{ $id }}' })" type="button"
                    class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-offset-2">
                    <span class="sr-only">Fermer</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="size-6">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <!-- En-tête de la modal -->
            @isset($title)
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                </div>
            @endisset

            <!-- Contenu de la modal -->
            <div class="w-full">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
