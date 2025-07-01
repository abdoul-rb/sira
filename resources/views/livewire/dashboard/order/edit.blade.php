@section('title', __('Éditer une commande'))

<div>
    <x-ui.breadcrumb :items="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard.index', ['tenant' => $tenant])],
        ['label' => 'Commandes', 'url' => route('dashboard.orders.index', ['tenant' => $tenant])],
        ['label' => 'Édition commande', 'url' => '#'],
    ]" />

    <h1 class="text-2xl font-bold text-gray-800 mt-6 mb-8">Édition commande</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form wire:submit="update" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
                <header class="flex flex-col gap-3 px-6 py-4">
                    <h3 class="text-base font-medium leading-6 text-gray-950">
                        Général
                    </h3>
                </header>

                <div class="border-t border-gray-200 px-4 py-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-6">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700">
                            {{ __('Client') }}
                        </label>

                        <div class="mt-1 grid grid-cols-1">
                            <select id="customer_id" name="customer_id" wire:model.live="customer_id"
                                class="col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-1.5 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="">Sélectionner un client</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div></div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            {{ __('Statut') }}
                        </label>

                        <div class="mt-1 grid grid-cols-1">
                            <select id="status" name="status" wire:model.live="status"
                                class="col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-2 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="notes" class="block text-sm font-medium text-gray-700">
                            {{ __('Notes') }}
                        </label>
                        <div class="mt-1">
                            <textarea rows="2" name="notes" wire:model.live="notes" id="notes"
                                class="block w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-base text-gray-900 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
            <header class="flex flex-col gap-3 px-6 py-4">
                <h3 class="text-base font-medium leading-6 text-gray-950">
                    {{ __('Récapitulatif') }}
                </h3>
            </header>

            <div class="border-t border-gray-200 px-6 py-4">
                <dl class="-my-3 divide-y divide-gray-100 px-2 py-4 text-sm/6">
                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">
                            {{ __('Date de commande') }}
                        </dt>
                        <dd class="text-gray-700">
                            <time
                                datetime="{{ $order->created_at->format('Y-m-d') }}">{{ $order->created_at->format('d/m/Y') }}</time>
                        </dd>
                    </div>

                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">
                            {{ __('Sous total') }}
                        </dt>

                        <dd class="flex items-start gap-x-2">
                            <div class="font-medium text-gray-900">
                                {{ number_format($order->subtotal ?? 0, 2, ',', ' ') }} €</div>
                        </dd>
                    </div>

                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">
                            {{ __('Montant total') }}
                        </dt>

                        <dd class="flex items-start gap-x-2">
                            <div class="font-medium text-gray-900">
                                {{ number_format($order->total_amount ?? 0, 2, ',', ' ') }} €
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl lg:col-span-2 ">
            <header class="flex flex-col gap-3 px-6 py-4">
                <h3 class="text-base font-medium leading-6 text-gray-950">
                    Adresses
                </h3>
            </header>

            <div class="border-t border-gray-200 px-4 py-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-6">
                <x-form.input name="shipping_cost" label="Frais de livraison" :number="true" />

                <div></div>

                <x-form.input name="shipping_address" label="Adresse de livraison" :wire="true" />

                <x-form.input name="billing_address" label="Adresse de facturation" :wire="true" />
            </div>
        </div>

        <div class="lg:col-span-full">
            <button type="submit"
                class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-blue-600 px-3 py-2 text-sm text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600 cursor-pointer">
                {{ __('Enregistrer') }}
            </button>
        </div>
    </form>
</div>
