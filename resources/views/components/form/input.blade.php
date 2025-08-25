@props([
    'label',
    'name',
    'type' => 'text',
    'value',
    'wire' => false,
    'live' => false,
    'searchable' => false,
    'number' => false,
    'placeholder',
    'required' => false,
    'disabled' => false,
])

@php
    $slug = str()->slug($name);
    $value ??= '';

    $autocomplete = match ($name) {
        'firstname' => 'given-name',
        'lastname' => 'family-name',
        'email' => 'email',
        'password' => 'current-password',
        default => 'off',
    };
@endphp

<div {{ $attributes }}>
    @if (isset($label) && !empty($label))
        <label for="{{ $slug }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input type="{{ $type }}" @class([
        'mt-1' => isset($label) && !empty($label),
        'block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-2 focus:ring-black focus:ring-opacity-50 text-sm',
    ]) name="{{ $name }}" id="{{ $slug }}"
        value="{{ old($name, $value) }}" @if ($wire) wire:model.lazy="{{ $name }}" @endif
        @if ($searchable && !$wire) wire:model.live.debounce.300ms="{{ $name }}" @endif
        @if ($live && !$wire) wire:model.live.debounce.300ms="{{ $name }}" @endif
        @if ($number && !$wire) wire:model.live.number="{{ $name }}" @endif
        @if (isset($placeholder) && !empty($placeholder)) placeholder="{{ $placeholder }}" @endif @disabled($disabled)
        @required($required) autocomplete="{{ $autocomplete }}">

    @error($name)
        <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
