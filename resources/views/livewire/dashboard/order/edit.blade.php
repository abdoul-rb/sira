@extends('layouts.dashboard')

@section('content')
    <x-ui.breadcrumb :items="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard.index', ['tenant' => $tenant])],
        ['label' => 'Commandes', 'url' => route('dashboard.orders.index', ['tenant' => $tenant])],
        ['label' => 'Édition commande', 'url' => '#'],
    ]" />

    <h1 class="text-2xl font-bold mb-6">Édition commande</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="update" class="grid grid-cols-3 gap-8">
        <div class="col-span-2 space-y-4">
            <x-form.input wire:model.defer="data.order_number" label="Numéro de commande" />
            <x-form.input wire:model.defer="data.total_amount" label="Montant total (€)" type="number" step="0.01" />
            <x-form.input wire:model.defer="data.tax_amount" label="Montant TVA (€)" type="number" step="0.01" />
            <x-form.input wire:model.defer="data.shipping_cost" label="Frais de port (€)" type="number" step="0.01" />
            <x-form.input wire:model.defer="data.shipping_address" label="Adresse de livraison" />
            <x-form.input wire:model.defer="data.billing_address" label="Adresse de facturation" />
            <x-form.input wire:model.defer="data.customer_id" label="ID client (à remplacer par select plus tard)" />
            <x-form.input wire:model.defer="data.quotation_id" label="ID devis (optionnel)" />
            <x-form.input wire:model.defer="data.status" label="Statut" as="select">
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </x-form.input>
            <x-form.input wire:model.defer="data.notes" label="Notes" as="textarea" />
        </div>
        <div class="col-span-1 space-y-4">
            <button type="submit" class="btn btn-primary w-full">Enregistrer</button>
        </div>
    </form>
@endsection
