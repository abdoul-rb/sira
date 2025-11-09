@props(['tenant'])

<x-ui.modals.base id="create-product" size="xl">
    <x-slot:title>
        {{ __('Créer un nouveau produit') }}
    </x-slot:title>

    <livewire:dashboard.product.create :tenant="$tenant" key="create-product" />
</x-ui.modals.base>
