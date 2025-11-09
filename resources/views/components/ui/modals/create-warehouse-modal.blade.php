@props(['tenant'])

<x-ui.modals.base id="create-warehouse" size="xl">
    <x-slot:title>
        {{ __('Ajouter un entrepôt') }}
    </x-slot:title>

    <livewire:dashboard.settings.warehouse.create :tenant="$tenant" key="create-wirehouse" />
</x-ui.modals.base>
