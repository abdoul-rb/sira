@props(['tenant'])

<x-ui.modals.base id="create-expense" size="xl">
    <x-slot:title>
        {{ __('Enregistrer une dépense') }}
    </x-slot:title>

    @livewire('dashboard.settings.expenses.create', ['tenant' => $tenant], key('create-expense'))
</x-ui.modals.base>
