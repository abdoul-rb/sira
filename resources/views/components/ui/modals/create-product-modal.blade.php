@props(['tenant'])

<x-ui.modals.base id="create-product" size="xl">
    <x-slot:title>
        {{ __('Nouveau produit') }}
    </x-slot:title>

    <livewire:dashboard.products.create :tenant="$tenant" key="create-product" />
</x-ui.modals.base>