@props(['type' => 'button', 'icon' => true])

<button type="button" {{ $attributes }}
    class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-1.5 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-gray-900 cursor-pointer">
    @if ($icon)
        <svg class="size-4 transition duration-75 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
            </path>
        </svg>
    @endif
    {{ $slot }}
</button>

{{-- <button type="button" @click="$dispatch('open-modal', { id: 'create-product' })"
    class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-gray-900 cursor-pointer">
    <svg class="size-4 transition duration-75 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
    </svg>
    {{ __('Ajouter un produit') }}
</button> --}}
