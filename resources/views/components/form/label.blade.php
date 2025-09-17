@props(['label', 'id', 'required' => false])

<label for="{{ $id }}" class="block text-xs font-medium text-gray-600">
    {{ $label }}
    @if ($required)
        <span class="text-red-500">*</span>
    @endif
</label>
