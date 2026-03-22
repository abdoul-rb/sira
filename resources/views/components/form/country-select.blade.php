@props(['name', 'label', 'required' => false])

<div {{ $attributes->merge(['class' => '']) }}>
    <x-form.label :label="$label" :id="$name" :required="$required" />

    <div class="mt-1 relative" x-data="{ open: false, top: 0, left: 0 }" x-ref="container" @click.away="open = false">
        <!-- Trigger Button -->
        <button type="button" x-ref="trigger"
            @click="open = !open; if (open) { const r = $refs.trigger.getBoundingClientRect(); top = r.bottom + 4; left = r.left; $refs.dropdown.style.width = r.width + 'px'; }"
            class="flex w-full items-center justify-between gap-2 rounded-md border border-gray-300 py-1 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black text-sm bg-white hover:bg-gray-50">
            <span class="flex items-center gap-2">
                @php
                    $val = $this->{$name};
                    $selectedCountry = collect($this->countries)->first(function ($country, $code) use ($val) {
                        return $code === $val || $country['name'] === $val;
                    });
                @endphp

                @if($selectedCountry)
                    <span class="text-lg">{{ $selectedCountry['flag'] }}</span>
                    <span class="font-medium">{{ $selectedCountry['name'] }}</span>
                @else
                    <span class="text-gray-400">Sélectionner un pays</span>
                @endif
            </span>
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <!-- Dropdown -->
        <div x-show="open" x-ref="dropdown" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95" :style="`top: ${top}px; left: ${left}px;`"
            class="fixed z-50 rounded-md bg-white shadow-lg ring-1 ring-gray-200 ring-opacity-5 max-h-60 overflow-y-auto"
            style="display: none;">
            @foreach ($this->countries as $code => $country)
                @php
                    $isSelected = $this->{$name} === $code || $this->{$name} === $country['name'];
                @endphp

                <button type="button" wire:click="$set('{{ $name }}', '{{ addslashes($country['name']) }}')"
                    @click="open = false"
                    class="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $isSelected ? 'bg-gray-50' : '' }}">
                    <span class="text-lg">{{ $country['flag'] }}</span>
                    <span class="flex-1 text-left font-medium">{{ $country['name'] }}</span>
                </button>
            @endforeach
        </div>
    </div>

    @error($name)
        <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>