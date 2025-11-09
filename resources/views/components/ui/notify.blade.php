<div {{ $attributes->class(['pointer-events-none fixed inset-0 z-50 flex items-end px-4 py-6 sm:items-start sm:p-6']) }}
    aria-live="assertive" x-data="{ show: false, message: '' }" x-init="if (show) { setTimeout(() => show = false, 3000) }"
    @notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 5000)" x-show="show"
    x-transition>
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
        <div
            class="pointer-events-auto w-full max-w-sm translate-y-0 transform rounded-lg bg-gray-900 opacity-100 shadow-lg outline outline-1 outline-black/5 transition duration-300 ease-out sm:translate-x-0 [@starting-style]:translate-y-2 [@starting-style]:opacity-0 [@starting-style]:sm:translate-x-2 [@starting-style]:sm:translate-y-0">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex w-0 flex-1 justify-between">
                        <p class="w-0 flex-1 text-sm font-medium text-white" x-text="message"></p>
                    </div>
                    <div class="ml-4 flex shrink-0">
                        <button type="button" @click="show = false"
                            class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-offset-2 focus:outline-gray-600">
                            <span class="sr-only">Close</span>
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                class="size-5">
                                <path
                                    d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
