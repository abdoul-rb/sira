@props(['tenant'])

<x-ui.modals.base id="add-customer" size="xl">
    <x-slot:title>
        {{ __('Ajouter un client') }}
    </x-slot:title>

    <livewire:dashboard.customers.create :tenant="$tenant" :key="'add-customer-' . time()" />
</x-ui.modals.base>
