@props(['credit'])

@php
    $order = $credit->order;
    $totalAmount = (float) ($order->total_amount ?? 0);
    $totalPaid = $credit->total_paid;
    $remaining = $credit->remaining_amount;
    $progressPercent = $totalAmount > 0 ? min(100, round(($totalPaid / $totalAmount) * 100)) : 0;
    $status = $credit->computed_status;
@endphp

<div class="bg-gray-100 border border-gray-200 rounded-lg p-4 flex flex-col gap-3">

    <!-- En-tête : Client (gauche) + Numéro commande (droite) -->
    <div class="flex items-start justify-between gap-2">
        <div class="flex items-center gap-2 min-w-0">
            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 shrink-0">
                <span class="text-xs font-semibold text-blue-600">
                    {{ $order->customer?->initials ?? '?' }}
                </span>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">
                    {{ $order->customer?->fullname ?? '-' }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                    {{ $order->customer?->phone_number ?? $order->customer?->email ?? '-' }}
                </p>
            </div>
        </div>

        <div class="flex flex-col items-end gap-1 shrink-0">
            <span class="text-xs font-medium text-gray-500">
                #{{ strtoupper($order->order_number) }}
            </span>
            <span
                class="inline-flex items-center gap-x-1 rounded-full px-2 py-0.5 text-xs font-medium {{ $status->color() }}">
                <svg viewBox="0 0 6 6" aria-hidden="true" class="size-1.5" fill="currentColor">
                    <circle r="3" cx="3" cy="3" />
                </svg>
                {{ $status->label() }}
            </span>
        </div>
    </div>

    <!-- Items de la commande -->
    <div class="rounded-lg bg-white px-4 py-3 space-y-2">
        @forelse ($order->productLines as $item)
            <div class="flex items-center justify-between text-xs text-gray-600">
                <span class="truncate">{{ $item->product->name ?? '—' }} × {{ $item->quantity }}</span>
                <span class="font-medium text-gray-800 ml-2 shrink-0">
                    {{ Number::currency($item->total_price, in: 'XOF', locale: 'fr') }}
                </span>
            </div>
        @empty
            <p class="text-xs text-gray-400 text-center py-1">Aucun produit.</p>
        @endforelse
    </div>

    <!-- Barre de progression -->
    <div>
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs text-gray-500">Avancement du paiement</span>
            <span class="text-xs font-semibold text-gray-700">{{ $progressPercent }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
            <div class="h-2 rounded-full transition-all duration-500
                    {{ $progressPercent >= 100 ? 'bg-green-500' : ($progressPercent >= 50 ? 'bg-blue-500' : 'bg-yellow-400') }}"
                style="width: {{ $progressPercent }}%">
            </div>
        </div>
    </div>

    <!-- Séparateur -->
    <hr class="border-gray-200">

    <!-- Récapitulatif -->
    <div class="grid grid-cols-3 gap-2 text-center">
        <div>
            <p class="text-xs text-gray-400">Total</p>
            <p class="text-xs font-semibold text-gray-800">
                {{ Number::currency($totalAmount, in: 'XOF', locale: 'fr') }}
            </p>
        </div>
        <div>
            <p class="text-xs text-gray-400">Payé</p>
            <p class="text-xs font-semibold text-green-600">
                {{ Number::currency($totalPaid, in: 'XOF', locale: 'fr') }}
            </p>
        </div>
        <div>
            <p class="text-xs text-gray-400">Reste</p>
            <p class="text-xs font-semibold {{ $remaining > 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ Number::currency($remaining, in: 'XOF', locale: 'fr') }}
            </p>
        </div>
    </div>

    <!-- Action -->
    @if ($remaining > 0)
        <div class="flex items-center gap-1 mt-1">
            <!-- Bouton enregistrer paiement -->
            <button type="button" wire:click="openPaymentModal({{ $credit->id }})"
                class="flex-1 flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Enregistrer un paiement
            </button>

            <!-- Bouton WhatsApp -->
            <a href="{{ whatsapp_reminder_url($order, $remaining) }}" target="_blank" rel="noopener noreferrer"
                title="Rappel WhatsApp"
                class="shrink-0 flex items-center justify-center p-2 rounded-lg bg-green-500 hover:bg-green-600 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
            </a>
        </div>
    @else
        <div
            class="w-full mt-1 flex items-center justify-center gap-2 rounded-lg bg-green-50 px-4 py-2 text-xs font-medium text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Créance soldée
        </div>
    @endif
</div>