@props(['product'])

<div class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
    @if ($product->featured_image)
        <img src="{{ Storage::disk('public')->url($product->featured_image) }}" alt="{{ $product->name }}"
            class="w-auto h-56 object-cover group-hover:opacity-75 aspect-auto" />
    @else
        <img src="https://placehold.co/380x224" alt=""
            class="w-auto h-56 object-cover group-hover:opacity-75 aspect-auto" />
    @endif

    <div class="flex flex-1 flex-col justify-between p-4">
        <div class="text-sm space-y-2">
            <h3 class="font-medium text-black">
                <a href="#">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ $product->name }}
                </a>
            </h3>
            <p class="font-light text-black/50">
                {{ str()->words($product->description ?? '', 10) }}
            </p>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <p class="text-sm font-medium text-black">
                {{ Number::currency($product->price, in: 'XOF', locale: 'fr') }}
            </p>

            <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full inline-block">
                Stock: {{ $product->stock_quantity }}
            </span>
        </div>
    </div>
</div>
