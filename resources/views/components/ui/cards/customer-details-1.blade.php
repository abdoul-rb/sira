@props(['customer', 'confirmingDelete' => null])
<div class="rounded-xl border border-gray-200 bg-white p-5 flex flex-col gap-2 relative">
    <div class="flex items-center justify-between">
        <div class="font-bold text-base text-gray-800">{{ $customer->fullname }}</div>
        <div class="flex items-center">
            <p class="{{ $customer->type->color() }} text-xs rounded-full px-4 py-0.5 font-medium">
                {{ $customer->type->label() }}
            </p>
        </div>
    </div>

    <div class="mt-2 flex flex-col gap-3 text-sm">
        <div class="inline-flex items-center gap-2 text-sm">
            <svg class="size-5 text-black/50 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75">
                </path>
            </svg>
            <a href="mailto:{{ $customer->email }}" class="text-black">{{ $customer->email }}</a>
        </div>

        <div class="inline-flex items-center gap-2 text-sm">
            <svg class="size-5 text-black/50 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z">
                </path>
            </svg>
            <a href="tel:{{ $customer->phone_number }}" class="text-black">{{ $customer->phone_number }}</a>
        </div>

        <div class="inline-flex items-center gap-2 text-sm">
            <svg class="size-5 text-black/50 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z">
                </path>
            </svg>
            <p class="text-black">
                {{ $customer->city }}, {{ $customer->country }}
            </p>
        </div>
    </div>

    <div class="flex flex-end gap-4 mt-4">
        <a href="{{ route('dashboard.customers.edit', ['tenant' => $currentTenant, 'customer' => $customer]) }}"
            class="flex items-center gap-1 text-black text-sm font-medium">
            <svg class="size-4 text-black/50 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
            </svg>
            Voir
        </a>

        @can('update', $customer)
            <a href="{{ route('dashboard.customers.edit', ['tenant' => $currentTenant, 'customer' => $customer]) }}"
                class="flex items-center gap-1 text-blue-600 text-sm font-medium">
                <svg class="size-4 text-blue/50 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                    </path>
                </svg>
                Éditer
            </a>
        @endcan

        @can('delete', $customer)
            <button wire:click="confirmDelete({{ $customer->id }})"
                class="flex items-center gap-1 text-red-600 text-sm font-medium cursor-pointer p-1">
                <svg class="size-5 text-red/50 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                    </path>
                </svg>
            </button>
        @endcan
    </div>

    @if ($confirmingDelete === $customer->id)
        <div class="absolute inset-0 bg-white/80 flex flex-col items-center justify-center z-10 rounded-xl">
            <div class="mb-2 text-gray-700">Confirmer la suppression ?</div>
            <div class="flex gap-2">
                <button wire:click="deleteCustomer({{ $customer->id }})"
                    class="px-3 py-1 bg-red-600 text-white rounded">Oui</button>
                <button wire:click="$set('confirmingDelete', null)" class="px-3 py-1 bg-gray-200 rounded">Non</button>
            </div>
        </div>
    @endif
</div>
