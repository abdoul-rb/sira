@props(['tenant'])

<x-ui.modals.base id="add-agent" size="xl">
    <x-slot:title>
        {{ __('Ajouter un nouvel agent') }}
    </x-slot:title>

    @livewire('dashboard.agent.add-modal', ['tenant' => $tenant], key('add-agent-' . now()))
</x-ui.modals.base>
