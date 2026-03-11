@props(['name' => 'phoneNumber', 'label' => 'Téléphone', 'required' => false, 'countryCode' => 'CI'])

<!-- Phone Number with Country Code -->
<div {{ $attributes->merge(['class' => 'lg:col-span-3']) }}>
    <x-form.label :label="$label" :id="$name" :required="$required" />

    <div class="mt-1 flex gap-1">
        <!-- Country Selector -->
        <div class="relative" x-data="{ open: false, top: 0, left: 0 }" x-ref="container">
            <button type="button" x-ref="trigger"
                @click="open = !open; if (open) { const r = $refs.trigger.getBoundingClientRect(); top = r.bottom + 4; left = r.left; }"
                @click.away="open = false"
                class="inline-flex items-center justify-between gap-2 rounded-md border border-gray-300 py-1 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black text-sm bg-white hover:bg-gray-50 min-w-[120px]">
                <span class="flex items-center gap-2">
                    <span class="text-lg">{{ $this->countries[$countryCode]['flag'] }}</span>
                    <span class="font-medium">{{ $this->countries[$countryCode]['dial_code'] }}</span>
                </span>
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95" :style="`top: ${top}px; left: ${left}px`"
                class="fixed z-50 w-64 rounded-md bg-white shadow-lg ring-1 ring-gray-200 ring-opacity-5 max-h-60 overflow-y-auto"
                style="display: none;">
                <div class="py-1">
                    @foreach ($this->countries as $code => $country)
                        <button type="button" wire:click="$set('countryCode', '{{ $code }}')" @click="open = false"
                            class="flex items-center gap-3 w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 {{ $countryCode === $code ? 'bg-gray-50' : '' }}">
                            <span class="text-lg">{{ $country['flag'] }}</span>
                            <span class="flex-1 text-left">{{ $country['name'] }}</span>
                            <span class="text-gray-500">{{ $country['dial_code'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Phone Number Input -->
        <div class="flex-1">
            <input type="tel" name="{{ $name }}" wire:model.live="{{ $name }}" id="{{ $name }}"
                placeholder="01 02 03 04 05"
                class="block w-full rounded-md border border-gray-300 py-2 px-3 text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-1 focus:ring-black text-sm bg-white">
        </div>
    </div>

    @error($name)
        <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
    @enderror

    @error('countryCode')
        <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>