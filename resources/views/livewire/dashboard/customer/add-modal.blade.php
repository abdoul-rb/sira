<form wire:submit.prevent="save" class="grid grid-cols-2 gap-x-2 gap-y-4" novalidate>
    {{-- <div class="col-span-full">
        <x-form.label label="Titre" id="title" />

        <select wire:model.live="title" name="title" id="title"
            class="mt-1 w-full rounded-md border-gray-300 text-sm focus:ring-teal-600">
            @foreach (['Mme', 'Mlle', 'M.'] as $title)
                <option value="{{ $title }}">{{ $title }}</option>
            @endforeach
        </select>
        @error('title')
            <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div> --}}

    <div class="col-span-full">
        <x-form.label label="Type de client" id="type" :required="true" />
        <select wire:model.live="type" name="type" id="type"
            class="mt-1 w-full rounded-md border-gray-300 text-sm focus:ring-teal-600">
            @foreach ($types as $type)
                <option value="{{ $type->value }}">{{ $type->label() }}</option>
            @endforeach
        </select>
        @error('type')
            <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <x-form.input class="col-span-1" name="firstname" label="Prénom" :wire="true" :required="true" />
    <x-form.input class="col-span-1" name="lastname" label="Nom" :wire="true" :required="true" />

    <x-form.input class="col-span-full" name="email" label="Email" :wire="true" type="email" />
    <x-form.input class="col-span-full" name="phone_number" label="Téléphone" :wire="true" />

    <x-form.input class="col-span-full" name="address" label="Adresse" :wire="true" />

    <!-- Boutons d'action -->
    <div class="col-span-full flex justify-between gap-3 pt-2">
        <button type="button" @click="$dispatch('close-modal', { id: 'add-customer' })"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-white border border-gray-300 px-3 py-2 text-sm text-black focus-visible:outline focus-visible:outline-offset-2 hover:bg-gray-100">
            {{ __('Annuler') }}
        </button>

        <button type="submit"
            class="w-full inline-flex items-center justify-center gap-x-1.5 rounded-md bg-black px-3 py-2 text-sm text-white shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-black">
            {{ __('Enregistrer') }}
        </button>
    </div>
</form>
