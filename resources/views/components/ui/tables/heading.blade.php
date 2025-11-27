@props(['sortable' => null, 'direction' => null, 'align' => 'left'])

@php
    $align = match ($align) {
        'left' => 'justify-start',
        'right' => 'justify-end',
        default => 'justify-center',
    };
@endphp

<th {{ $attributes->merge(['class' => 'px-6 py-4 whitespace-nowrap']) }} scope="col">
    <div class="flex items-center {{ $align }} gap-x-2">
        {{ $slot }}

        @if ($sortable)
            <button type="button" class="flex items-center px-1 py-0.5 cursor-pointer">
                <svg class="w-3 h-2 text-dark/25 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 7"
                    fill="currentColor">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.95346 6.19419L7.90533 1.46101C8.08832 1.16651 7.99808 0.779015 7.70359 0.5959C7.60026 0.531463 7.48536 0.501133 7.37184 0.501259V0.5H1.45677C1.10929 0.5 0.827637 0.781783 0.827637 1.12914C0.827637 1.2648 0.870427 1.39053 0.943547 1.49323L3.88107 6.20376C4.06418 6.498 4.45168 6.58836 4.74618 6.40525C4.83415 6.3505 4.90375 6.27763 4.95346 6.19419Z"
                        fill="currentColor" />
                </svg>
            </button>
        @endif
    </div>
</th>