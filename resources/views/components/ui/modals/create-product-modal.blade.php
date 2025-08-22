@props(['tenant'])

<x-ui.modals.base-modal id="create-product" size="xl">
    <x-slot:title>
        {{ __('Créer un nouveau produit') }}
    </x-slot:title>

    @livewire('dashboard.product.create', ['tenant' => $tenant], key('create-product-' . now()))
</x-ui.modals.base-modal>
