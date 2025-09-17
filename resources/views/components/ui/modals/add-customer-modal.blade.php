@props(['tenant'])

<x-ui.modals.base id="add-customer" size="xl">
    <x-slot:title>
        {{ __('Ajouter un client') }}
    </x-slot:title>

    @livewire('dashboard.customer.add-modal', ['tenant' => $tenant], key('add-customer-' . now()))
</x-ui.modals.base>
