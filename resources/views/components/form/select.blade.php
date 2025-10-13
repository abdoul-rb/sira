@props(['label', 'name', 'options', 'wire', 'required' => false])

<div {{ $attributes }}>
    <label for="customer_id" class="block text-sm font-medium text-gray-700">
        {{ __('Client') }}
    </label>

    <div class="mt-1">
        <select id="customer_id" name="customer_id" wire:model.live="customer_id"
            class="col-start-1 row-start-1 w-full rounded-md border border-gray-300 text-gray-900 placeholder:text-gray-400 focus:border-0 focus:ring-2 focus:ring-inset focus:ring-teal-600 text-sm sm:leading-6 transition duration-150 appearance-none bg-white py-1.5 pl-3 pr-8 -outline-offset-1 outline-gray-300 focus:outline focus:-outline-offset-1 focus:outline-indigo-600 sm:text-sm/6">
            <option value="">Sélectionner un client</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->fullname }}</option>
            @endforeach
        </select>
    </div>

    @error('customer_id')
        <p class="mt-1 font-normal text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
