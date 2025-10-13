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
                            <div class="font-medium text-gray-900">{{ number_format($subtotal, 2, ',', ' ') }} €</div>
                        </dd>
                    </div>

                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">
                            {{ __('Frais de livraison') }}
                        </dt>

                        <dd class="flex items-start gap-x-2">
                            <div class="font-medium text-gray-900">
                                {{ number_format($shipping_cost ?? 0, 2, ',', ' ') }} €</div>
                        </dd>
                    </div>

                    <div class="flex justify-between gap-x-4 py-3 border-t border-gray-200">
                        <dt class="text-gray-900 font-medium">
                            {{ __('Montant total') }}
                        </dt>

                        <dd class="flex items-start gap-x-2">
                            <div class="font-bold text-gray-900 text-lg">
                                {{ number_format($total_amount, 2, ',', ' ') }} €</div>
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

        <!-- Produits existants (lecture seule) -->
        @if ($order->products->count() > 0)
            <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl lg:col-span-full">
                <header class="flex flex-col gap-3 px-6 py-4">
                    <h3 class="text-base font-medium leading-6 text-gray-950">
                        Produits commandés
                    </h3>
                </header>

                <div class="border-t border-gray-200 px-4 py-6 sm:p-8">
                    <div class="grid lg:grid-cols-12 gap-x-12 gap-y-5 mb-4 items-center">
                        <div class="lg:col-span-5">
                            <span class="block text-sm font-medium text-gray-700">Produit</span>
                        </div>
                        <div class="lg:col-span-3 flex items-center justify-between gap-2">
                            <div class="text-right">
                                <span class="block text-sm font-medium text-gray-700">{{ __('Prix unitaire') }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-700">{{ __('Quantité') }}</span>
                            </div>
                        </div>
                        <div class="lg:col-span-2 text-right">
                            <span class="block text-sm font-medium text-gray-700">{{ __('Total') }}</span>
                        </div>
                        <div class="lg:col-span-2"></div>
                    </div>

                    @foreach ($order->products as $product)
                        <div class="grid lg:grid-cols-12 gap-x-12 gap-y-5 mb-4 items-center">
                            <div class="lg:col-span-5">
                                <span class="block text-gray-900">{{ $product->sku }} / {{ $product->name }}</span>
                            </div>
                            <div class="lg:col-span-3 flex items-center justify-between gap-2">
                                <div class="text-right">
                                    <span
                                        class="block text-gray-900">{{ number_format($product->pivot->unit_price, 2, ',', ' ') }}
                                        €</span>
                                </div>
                                <div>
                                    <span class="block text-gray-900">{{ $product->pivot->quantity }}</span>
                                </div>
                            </div>
                            <div class="lg:col-span-2 text-right">
                                <span
                                    class="block font-medium text-gray-900">{{ number_format($product->pivot->total_price, 2, ',', ' ') }}
                                    €</span>
                            </div>
                            <div class="lg:col-span-2"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Nouveaux produits -->
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl lg:col-span-full">
            <header class="flex flex-col gap-3 px-6 py-4">
                <h3 class="text-base font-medium leading-6 text-gray-950">
                    Ajouter des produits
                </h3>
            </header>

            <div class="border-t border-gray-200 px-4 py-6 sm:p-8">
                <!-- Lignes de nouveaux produits -->
                @foreach ($productLines as $index => $line)
                    <div class="grid lg:grid-cols-12 gap-x-12 gap-y-5 mb-4 items-center">
                        <!-- Sélecteur de produit -->
                        <div class="lg:col-span-5">
                            <label for="product_id" class="block text-sm font-medium text-gray-700">
                                Produit
                            </label>
                            <select wire:model.live="productLines.{{ $index }}.product_id" id="product_id"
                                class="mt-4 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-2 pl-3 pr-8">
                                <option value="">Sélectionner un produit</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->sku }} / {{ $product->name }} (Stock:
                                        {{ $product->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error("productLines.{$index}.product_id")
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="lg:col-span-3 flex items-center justify-between gap-2">
                            <!-- Prix unitaire -->
                            <div class="text-right">
                                <label for="product_id" class="block text-sm font-medium text-gray-700">
                                    {{ __('Prix unitaire') }}
                                </label>
                                <span class="mt-4 block text-gray-900 py-2">
                                    {{ number_format($line['unit_price'], 2, ',', ' ') }} €
                                </span>
                            </div>

                            <!-- Quantité -->
                            <div>
                                <label for="product_id" class="block text-sm font-medium text-gray-700">
                                    {{ __('Quantité') }}
                                </label>

                                <input type="number" wire:model.number="productLines.{{ $index }}.quantity"
                                    min="1" max="{{ $line['available_stock'] }}"
                                    class="mt-4 w-28 rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 px-3 py-2">
                                @error("productLines.{$index}.quantity")
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Total de la ligne -->
                        <div class="lg:col-span-2 text-right">
                            <span class="block text-sm font-medium text-gray-700">
                                {{ __('Total') }}
                            </span>
                            <span class="mt-4 block text-gray-900 py-2">
                                {{ number_format($line['total_price'], 2, ',', ' ') }} €
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="lg:col-span-2 text-center">
                            @if (count($productLines) > 1)
                                <button type="button" wire:click="removeProductLine({{ $index }})"
                                    class="text-red-600 hover:text-red-800 text-sm">
                                    Supprimer
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Bouton pour ajouter une ligne -->
                <div class="mt-4">
                    <button type="button" wire:click="addProductLine"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow text-sm font-medium rounded-md text-black bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        + Ajouter un produit
                    </button>
                </div>
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
