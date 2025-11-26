@props(['mainLabel', 'mainValue', 'subLabel', 'subValue', 'link' => null])


<div {{ $attributes->class(['rounded-xl border border-gray-200 bg-white p-5 relative overflow-hidden flex flex-col group cursor-pointer transition hover:border-blue-400']) }}>
    <a href="{{ $link }}" class="absolute inset-0 z-10"></a>

    <div class="flex justify-between items-start mb-2">
        <div>
            <p class="block text-sm text-gray-500">
                {{ $mainLabel }}
            </p>
            <h3 class="mt-2 text-xl font-bold text-gray-800">
                {{ $mainValue }}
            </h3>
        </div>
        @isset($mainIcon)
            <div class="p-2 bg-blue-50 rounded-lg">
                {{ $mainIcon }}
            </div>
        @endisset
    </div>

    <div class="mt-auto pt-2 border-t border-dashed border-gray-200 flex justify-between items-center">
        <div class="flex flex-col">
            <span class="block text-xs text-gray-400 font-medium">
                {{ $subLabel }}
            </span>
            <span class="text-sm font-semibold text-red-500 flex items-center mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    data-lucide="trending-down" class="lucide lucide-trending-down w-3 h-3 mr-1">
                    <path d="M16 17h6v-6"></path>
                    <path d="m22 17-8.5-8.5-5 5L2 7"></path>
                </svg>
                - {{ $subValue }}
            </span>
        </div>
        <!-- Petit indicateur visuel pour dire "cliquez pour voir le journal" -->
        <div class="text-xs text-blue-600 font-medium flex items-center group-hover:underline">
            Journal
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-3 h-3 ml-1">
                <path d="m9 18 6-6-6-6"></path>
            </svg>
        </div>
    </div>
</div>