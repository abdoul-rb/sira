@props(['tenant'])

<x-ui.modals.base id="create-supplier" size="xl">
    <x-slot:title>
        {{ __('Ajouter un fournisseur') }}
    </x-slot:title>

    <livewire:dashboard.settings.suppliers.create :tenant="$tenant" :key="'create-supplier' . time()" />
</x-ui.modals.base>
