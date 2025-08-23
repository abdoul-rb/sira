@props(['customer', 'orders'])

<x-ui.modals.base id="show-customer-orders" size="xl">
    <x-slot:title>
        {{ __('Commande du client') }}
    </x-slot:title>

    <!-- Contenu : affichage des commandes du client selectionné -->
</x-ui.modals.base>
