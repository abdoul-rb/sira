@props(['tenant'])

<x-ui.modals.base id="create-order" size="xl">
    <x-slot:title>
        {{ __('Ajouter une vente') }}
    </x-slot:title>

    @livewire('dashboard.components.order.create-modal', ['tenant' => $tenant], key('create-order-' . now()))
</x-ui.modals.base>
