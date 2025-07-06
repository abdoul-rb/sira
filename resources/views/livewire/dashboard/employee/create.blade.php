@section('title', __('Créer un employé'))

<div>
    <x-ui.breadcrumb :items="[
        ['label' => 'Tableau de bord', 'url' => route('dashboard.index', ['tenant' => $tenant])],
        ['label' => 'Employés', 'url' => route('dashboard.employees.index', ['tenant' => $tenant])],
        ['label' => 'Nouvel employé', 'url' => '#'],
    ]" />

    <h1 class="text-2xl font-bold text-gray-800 mt-6 mb-8">Nouvel employé</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations générales -->
            <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
                <header class="flex flex-col gap-3 px-6 py-4">
                    <h3 class="text-base font-medium leading-6 text-gray-950">
                        Informations générales
                    </h3>
                </header>

                <div class="border-t border-gray-200 px-4 py-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-6">
                    <x-form.input name="firstname" label="Prénom" :wire="true" />

                    <x-form.input name="lastname" label="Nom" :wire="true" />

                    <x-form.input name="phone_number" label="Téléphone" :wire="true" />

                    <x-form.input type="date" name="hire_date" label="Date d'embauche" :wire="true" />

                    <x-form.input name="position" label="Poste" :wire="true" />

                    <x-form.input name="department" label="Département" :wire="true" />

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="active" id="active"
                            class="h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-600">
                        <label for="active" class="ml-2 block text-sm text-gray-900">
                            {{ __('Employé actif') }}
                        </label>
                    </div>
                </div>
            </div>

            <!-- Accès utilisateur -->
            <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
                <header class="flex flex-col gap-3 px-6 py-4">
                    <h3 class="text-base font-medium leading-6 text-gray-950">
                        Accès utilisateur
                    </h3>
                </header>

                <div class="border-t border-gray-200 px-4 py-6 sm:p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Peut se connecter</h4>
                            <p class="text-sm text-gray-500">Permettre à cet employé d'accéder à la plateforme</p>
                        </div>
                        <div class="flex items-center">
                            <button type="button" wire:click="$toggle('can_login')"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 {{ $can_login ? 'bg-teal-600' : 'bg-gray-200' }}"
                                role="switch" aria-checked="{{ $can_login ? 'true' : 'false' }}">
                                <span class="sr-only">Peut se connecter</span>
                                <span
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $can_login ? 'translate-x-5' : 'translate-x-0' }}">
                                </span>
                            </button>
                        </div>
                    </div>

                    @if ($can_login)
                        <div class="mt-6 space-y-6">
                            <x-form.input name="email" label="Email" :wire="true" />

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">
                                    {{ __('Rôle') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <select wire:model="role" id="role" required
                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6">
                                        <option value="">Sélectionner un rôle</option>
                                        <option value="employee">Employé</option>
                                        <option value="manager">Manager</option>
                                    </select>
                                </div>
                                @error('role')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="rounded-md bg-blue-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">
                                            Invitation automatique
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>
                                                Un email d'invitation sera automatiquement envoyé à l'adresse indiquée
                                                pour permettre à l'employé de définir son mot de passe.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Récapitulatif -->
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
                            {{ __('Entreprise') }}
                        </dt>
                        <dd class="text-gray-700">
                            {{ $tenant->name }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">
                            {{ __('Poste') }}
                        </dt>
                        <dd class="text-gray-700">
                            {{ $position ?: 'Non défini' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">
                            {{ __('Département') }}
                        </dt>
                        <dd class="text-gray-700">
                            {{ $department ?: 'Non défini' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">
                            {{ __('Statut') }}
                        </dt>
                        <dd class="text-gray-700">
                            @if ($active)
                                <span
                                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    Actif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                    Inactif
                                </span>
                            @endif
                        </dd>
                    </div>

                    @if ($can_login)
                        <div class="flex justify-between gap-x-4 py-3">
                            <dt class="text-gray-500">
                                {{ __('Accès') }}
                            </dt>
                            <dd class="text-gray-700">
                                <span
                                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                    {{ ucfirst($role) }}
                                </span>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <div class="lg:col-span-full">
            <button type="submit"
                class="inline-flex items-center justify-center gap-x-1.5 rounded-md bg-blue-600 px-3 py-2 text-sm text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600 cursor-pointer">
                {{ __('Créer l\'employé') }}
            </button>
        </div>
    </form>
</div>
