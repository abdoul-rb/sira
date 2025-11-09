@props(['tenant'])

<x-ui.modals.base id="add-purchase" size="xl">
    <x-slot:title>
        {{ __('Enregistrer un achat') }}
    </x-slot:title>

    <livewire:dashboard.purchases.create :tenant="$tenant" :key="'add-purchase-' . time()" />
</x-ui.modals.base>
