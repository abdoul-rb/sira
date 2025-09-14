@props(['label', 'value'])

<div class="flex justify-between gap-x-4 py-2">
    <dt class="text-sm text-gray-500">
        {{ __($label) }}
    </dt>

    <dd class="flex items-start gap-x-2">
        <div class="font-medium text-xs text-gray-900">
            {{ $value }}
        </div>
    </dd>
</div>
