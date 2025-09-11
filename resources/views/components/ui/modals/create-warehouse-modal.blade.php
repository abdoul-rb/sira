@props(['tenant'])

<x-ui.modals.base id="create-warehouse" size="xl">
    <x-slot:title>
        {{ __('Ajouter un entrepôt') }}
    </x-slot:title>

    @livewire('dashboard.warehouse.create-modal', ['tenant' => $tenant], key('create-wirehouse-' . now()))
</x-ui.modals.base>
