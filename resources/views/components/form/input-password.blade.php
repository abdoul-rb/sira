@props(['label', 'name', 'autocomplete', 'placeholder' => '*****************', 'wire' => false])

@php
    $slug = str()->slug($name);
@endphp

<div {{ $attributes }} x-data="{ showPassword: false }">
    @if (isset($label) && !empty($label))
        <x-form.label :label="$label" :id="$slug" :required="true" />
    @endif

    <div class="relative mt-2">
        <input :type="showPassword ? 'text' : 'password'" id="{{ $slug }}"
            @if (!$wire) name="{{ $name }}" @endif
            @if (isset($wire) && !empty($wire)) wire:model.lazy="{{ $name }}" @endif @class([
                'block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black focus:ring-opacity-50 text-sm',
            ])
            @if (isset($placeholder) && !empty($placeholder)) placeholder="{{ $placeholder }}" @endif>

        <button @click="showPassword = !showPassword" type="button"
            class="absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="w-4 h-4 text-gray-600 hover:text-gray-900"
                :class="{ 'hidden': showPassword, 'block': !showPassword }" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <svg class="w-4 h-4 text-gray-600 hover:text-gray-900"
                :class="{ 'hidden': !showPassword, 'block': showPassword }" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
        </button>
    </div>

    @error($name)
        <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
