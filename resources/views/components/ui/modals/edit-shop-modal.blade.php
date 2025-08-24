@props(['tenant'])

<x-ui.modals.base id="edit-shop" size="lg">
    <x-slot:title>
        {{ __('Gérer la boutique') }}
    </x-slot:title>

    @livewire('dashboard.shop.edit', ['tenant' => $tenant], key('edit-shop-' . now()))
</x-ui.modals.base>
