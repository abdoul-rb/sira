@props(['question', 'answer'])

<div x-data="{ open: false }" @click="open = !open" @class([
    'relative flex flex-col items-start self-stretch py-5 px-5 border rounded-lg mx-auto',
]) :class="'border-black/10'" itemscope itemprop="mainEntity"
    itemtype="https://schema.org/Question">
    <div class="flex items-center justify-between w-full cursor-pointer">
        <h3 class="text-sm text-gray-700 font-semibold max-w-2xl" itemprop="name">
            {{ __($question, ['app_name' => config('app.name')]) }}
        </h3>

        <svg class="shrink-0 transform transition-transform duration-200 cursor-pointer"
            :class="{ 'rotate-0': open, 'rotate-180': !open }" width="18" height="18" viewBox="0 0 18 18" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g opacity="0.5">
                <path d="M4.5 11.25L8.46967 7.28033C8.76256 6.98744 9.23744 6.98744 9.53033 7.28033L13.5 11.25"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </g>
        </svg>
    </div>

    <div x-show="open" class="mt-2 transition-all duration-300">
        <p class="text-start text-i-dark/50 text-sm font-light">
            {{ __($answer, ['app_name' => config('app.name')]) }}
        </p>
    </div>
</div>