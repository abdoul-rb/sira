@props(['tenant'])

<x-ui.modals.base id="create-member" size="xl">
    <x-slot:title>
        {{ __('Ajouter un personnel') }}
    </x-slot:title>

    @livewire('dashboard.members.create', ['tenant' => $tenant], key('create-member'))
</x-ui.modals.base>
