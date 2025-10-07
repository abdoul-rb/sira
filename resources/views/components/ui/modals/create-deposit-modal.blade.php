@props(['tenant'])

<x-ui.modals.base id="create-deposit" size="xl">
    <x-slot:title>
        {{ __('Enregistrer un versement') }}
    </x-slot:title>

    @livewire('dashboard.settings.deposits.create', ['tenant' => $tenant], key('create-deposit'))
</x-ui.modals.base>
