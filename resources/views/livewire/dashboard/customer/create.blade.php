<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <x-ui.breadcrumb :items="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard.index', ['tenant' => $tenant->slug])],
        ['label' => 'Clients', 'url' => route('dashboard.customers.index', ['tenant' => $tenant->slug])],
        ['label' => 'Créer', 'url' => '#'],
    ]" />

    <h1 class="text-2xl font-bold text-gray-800 mt-6 mb-8">Créer un client</h1>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-md px-4 py-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne principale (2/3) -->
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl lg:col-span-2">
            <header class="flex flex-col gap-3 px-6 py-4">
                <h3 class="text-base font-medium leading-6 text-gray-950">
                    General
                </h3>
            </header>
            <div class="border-t border-gray-200 px-4 py-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-6">
                {{-- <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Titre
                    </label>

                    <select wire:model.live="title" name="title" id="title"
                        class="mt-1 w-full rounded-md border-gray-300 text-sm focus:ring-teal-600">
                        @foreach (['Mme', 'Mlle', 'M.'] as $title)
                            <option value="{{ $title }}">{{ $title }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Type de client
                    </label>
                    <select wire:model.live="type" name="type" id="type"
                        class="mt-1 w-full rounded-md border-gray-300 text-sm focus:ring-teal-600">
                        @foreach ($types as $enum)
                            <option value="{{ $enum->value }}">{{ $enum->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <x-form.input name="firstname" label="Prénom" :wire="true" />
                <x-form.input name="lastname" label="Nom" :wire="true" />

                <x-form.input class="col-span-full" name="email" label="Email" :wire="true" type="email" />
                <x-form.input name="phone_number" label="Téléphone" :wire="true" />
            </div>
        </div>

        <!-- Colonne latérale (1/3) -->
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
            <header class="flex flex-col gap-3 px-6 py-4">
                <h3 class="text-base font-medium leading-6 text-gray-950">
                    {{ __('Adresse') }}
                </h3>
            </header>

            <div class="border-t border-gray-200 px-4 py-6 sm:p-8 grid grid-cols-1 gap-y-6">
                <x-form.input name="address" label="Adresse" :wire="true" />

                <x-form.input name="city" label="Ville" :wire="true" />

                <x-form.input name="zip_code" label="Code postal" :wire="true" />

                <x-form.input name="country" label="Pays" :wire="true" />
            </div>
        </div>

        <!-- Bouton de sauvegarde -->
        <div class="md:col-span-full">
            <button type="submit"
                class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-blue-600 px-3 py-2 text-sm text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                {{ __('Enregistrer') }}
            </button>
        </div>
    </form>
</div>
