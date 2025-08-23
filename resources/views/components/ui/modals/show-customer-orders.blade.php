@props(['tenant'])

<x-ui.modals.base id="create-product" size="xl">
    <x-slot:title>
        {{ __('Commande du client') }}
    </x-slot:title>

    @livewire('dashboard.product.create', ['tenant' => $tenant], key('create-product-' . now()))
</x-ui.modals.base>
