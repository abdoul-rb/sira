@props(['credit'])

@php
    $order = $credit->order;
    $status = $credit->computed_status;
@endphp

<x-ui.modals.base id="credit-detail-modal-{{ $credit->id }}" size="xl">
    <x-slot:title>
        Créance — #{{ strtoupper($order->order_number) }}
    </x-slot:title>

    <div class="space-y-5">
        {{-- Infos client --}}
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100">
                <span class="text-sm font-semibold text-blue-600">
                    {{ $order->customer?->initials ?? '?' }}
                </span>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ $order->customer?->fullname ?? '-' }}</p>
                <p class="text-xs text-gray-500">{{ $order->customer?->email ?? '-' }}</p>
            </div>
            <span
                class="ml-auto inline-flex items-center gap-x-1 rounded-full px-2 py-0.5 text-xs font-medium {{ $status->color() }}">
                {{ $status->label() }}
            </span>
        </div>

        {{-- Historique des versements --}}
        <div>
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Historique des versements</h4>

            @if ($credit->payments->isEmpty())
                <p class="text-sm text-gray-400 text-center py-4">Aucun versement enregistré.</p>
            @else
                <div class="divide-y divide-gray-100 rounded-lg border border-gray-200 overflow-hidden">
                    @foreach ($credit->payments as $payment)
                        <div class="flex items-center justify-between px-4 py-3 bg-white hover:bg-gray-50">
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ Number::currency($payment->amount, in: 'XOF', locale: 'fr') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $payment->payment_method }}
                                    @if ($payment->note)
                                        — {{ $payment->note }}
                                    @endif
                                </p>
                            </div>
                            <span class="text-xs text-gray-400">
                                {{ $payment->paid_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Récapitulatif --}}
        <div class="grid grid-cols-3 gap-3 rounded-lg bg-gray-50 px-4 py-3 text-center">
            <div>
                <p class="text-xs text-gray-400">Total</p>
                <p class="text-sm font-semibold text-gray-800">
                    {{ Number::currency($order->total_amount, in: 'XOF', locale: 'fr') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Payé</p>
                <p class="text-sm font-semibold text-green-600">
                    {{ Number::currency($credit->total_paid, in: 'XOF', locale: 'fr') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Reste</p>
                <p class="text-sm font-semibold text-red-600">
                    {{ Number::currency($credit->remaining_amount, in: 'XOF', locale: 'fr') }}
                </p>
            </div>
        </div>

        {{-- Bouton enregistrer un paiement --}}
        @if ($credit->remaining_amount > 0)
            <div class="flex justify-end">
                <button type="button" wire:click="openPaymentModal({{ $credit->id }})"
                    @click="$dispatch('close-modal', { id: 'credit-detail-modal-{{ $credit->id }}' })"
                    class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 transition-colors cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Enregistrer un paiement
                </button>
            </div>
        @endif
    </div>
</x-ui.modals.base>