@php use App\Enums\PaymentMethod; @endphp

<x-ui.modals.base id="record-payment-modal" size="md">
    <x-slot:title>
        Enregistrer un paiement
    </x-slot:title>

    <form wire:submit.prevent="save" class="space-y-5">
        <!-- Reste dû -->
        @if ($selectedCredit)
            <div class="flex items-center justify-between rounded-lg bg-red-50 border border-red-100 px-4 py-3">
                <span class="text-sm text-red-700 font-medium">Reste à payer</span>
                <span class="text-sm font-bold text-red-700">
                    {{ Number::currency($selectedCredit->remaining_amount, in: 'XOF', locale: 'fr') }}
                </span>
            </div>
        @endif

        <!-- Montant -->
        <div>
            <label for="paymentAmount" class="block text-sm font-medium text-gray-700 mb-1">
                Montant (FCFA) <span class="text-red-500">*</span>
            </label>
            <input id="paymentAmount" type="number" step="1" min="1" wire:model="paymentAmount" placeholder="Ex : 5000"
                class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none" />
            @error('paymentAmount')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mode de paiement -->
        <div>
            <h3 class="block text-sm font-medium text-gray-700 mb-2">
                Mode de paiement <span class="text-red-500">*</span>
            </h3>

            <div class="flex gap-x-4">
                @foreach (PaymentMethod::cases() as $method)
                    <div class="flex items-center">
                        <input type="radio" wire:model.live="paymentMethod" id="pm-{{ $method->value }}"
                            value="{{ $method->value }}"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-blue-600 checked:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600" />
                        <label for="pm-{{ $method->value }}"
                            class="ml-1 inline-flex items-center rounded-full px-2 py-1 text-xs font-medium cursor-pointer {{ $method->color() }}">
                            {{ $method->label() }}
                        </label>
                    </div>
                @endforeach
            </div>

            @error('paymentMethod')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Note -->
        <div>
            <label for="paymentNote" class="block text-sm font-medium text-gray-700 mb-1">
                Note (optionnel)
            </label>
            <textarea id="paymentNote" wire:model="paymentNote" rows="2" placeholder="Ajouter une note..."
                class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 focus:outline-none resize-none"></textarea>
            @error('paymentNote')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-1">
            <button type="button" @click="$dispatch('close-modal', { id: 'record-payment-modal' })"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer">
                Annuler
            </button>
            <button type="submit" wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 transition-colors disabled:opacity-50 cursor-pointer">
                <span wire:loading.remove wire:target="save">Enregistrer</span>
                <span wire:loading wire:target="save">Enregistrement...</span>
            </button>
        </div>
    </form>
</x-ui.modals.base>