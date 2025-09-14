<form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
    <div class="col-span-full">
        <label for="title" class="block text-sm font-medium text-gray-700">
            Titre
        </label>

        <select wire:model.live="title" name="title" id="title"
            class="mt-1 w-full rounded-md border-gray-300 text-sm focus:ring-teal-600">
            @foreach (['Mme', 'Mlle', 'M.'] as $title)
                <option value="{{ $title }}">{{ $title }}</option>
            @endforeach
        </select>
    </div>

    <x-form.input class="col-span-1" name="firstname" label="Prénom" :wire="true" :required="true" />

    <x-form.input class="col-span-1" name="lastname" label="Nom" :wire="true" :required="true" />

    <x-form.input class="col-span-full" name="phone_number" label="Téléphone" :wire="true" :required="true" />

    <x-form.input class="col-span-full" name="localization" label="Adresse" :wire="true" :required="true" />

    <!-- Boutons d'action -->
    <div class="col-span-full flex justify-between gap-3 pt-2">
        <button type="button" @click="$dispatch('close-modal', { id: 'add-agent' })"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
            {{ __('Annuler') }}
        </button>

        <button type="submit"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black">
            {{ __('Enregistrer') }}
        </button>
    </div>
</form>
