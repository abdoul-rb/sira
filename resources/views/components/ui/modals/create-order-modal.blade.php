@props(['tenant'])

<x-ui.modals.base id="create-order" size="xl">
    <x-slot:title>
        {{ __('Ajouter une vente') }}
    </x-slot:title>

    <livewire:dashboard.orders.create :tenant="$tenant" key="create-order" />
</x-ui.modals.base>
