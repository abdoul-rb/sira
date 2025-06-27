@props(['items' => []])

<nav class="sm:max-w-6xl mx-auto flex w-full px-0" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-2">
        @foreach ($items as $item)
            <li>
                <div class="flex items-center text-black/40"
                    @if ($loop->last) aria-current="page" @endif>
                    @if ($loop->first)
                        <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                            viewBox="0 0 21 21" fill="none">
                            <path d="M8.79946 15.8555L3.42187 10.5003L8.79946 5.14523" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M3.42188 10.5L16.7552 10.5" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    @endif

                    <a href="{{ $item['url'] }}" @class(['text-sm font-medium underline', 'ml-2' => $loop->first])>
                        {{ $item['label'] }}
                    </a>

                    @if (!$loop->last)
                        <svg class="ml-2 w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
