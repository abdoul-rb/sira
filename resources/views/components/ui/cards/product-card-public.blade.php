@props(['product'])

<div class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
    @if ($product->featured_image)
        <img src="{{ Storage::disk('public')->url($product->featured_image) }}" alt="{{ $product->name }}"
            class="w-auto h-56 object-cover group-hover:opacity-75 aspect-auto" />
    @else
        <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/category-page-02-image-card-01.jpg"
            alt="Eight shirts arranged on table in black, olive, grey, blue, white, red, mustard, and green."
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
                {{ str()->words($product->description ?? '', 14) }}
            </p>
        </div>

        <div class="mt-5 flex items-center justify-between">
            <p class="text-sm font-medium text-black">
                {{ Number::currency($product->price, in: 'XOF', locale: 'fr') }}
            </p>

            {{-- <button type="button"
                class="inline-flex items-center gap-2 text-xs text-black border border-gray-200 rounded-full px-3 py-1.5 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden">
                <svg class="size-3 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="8" cy="21" r="1"></circle>
                    <circle cx="19" cy="21" r="1"></circle>
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                </svg>
                Ajouter au panier
            </button> --}}
        </div>
    </div>
</div>
