@props(['product'])

<div class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
    <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/category-page-02-image-card-01.jpg"
        alt="Eight shirts arranged on table in black, olive, grey, blue, white, red, mustard, and green."
        class="w-auto h-56 object-cover group-hover:opacity-75 aspect-auto" />
    <div class="flex flex-1 flex-col space-y-2 p-4">
        <h3 class="text-sm font-medium text-black">
            <a href="#">
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{ $product->name }}
            </a>
        </h3>
        <p class="text-sm font-light text-black/50">
            {{ str()->words($product->description ?? '', 14) }}
        </p>
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-black">
                {{ Number::currency($product->price, in: 'XOF', locale: 'fr') }}
            </p>

            <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full inline-block">
                Stock: {{ $product->stock_quantity }}
            </span>
        </div>
    </div>
</div>
