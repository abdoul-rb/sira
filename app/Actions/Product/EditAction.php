<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class EditAction
{
    public function handle(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $product->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'sku' => $data['sku'],
                'price' => $data['price'],
                'stock_quantity' => $data['stockQuantity'],
            ]);

            /** @var UploadedFile|null $featuredImage */
            $featuredImage = $data['featuredImage'] ?? null;
            $imagePath = null;

            if ($featuredImage instanceof UploadedFile && !$featuredImage->getError()) {
                if ($featuredImage && Storage::disk('public')->exists($product->featured_image)) {
                    Storage::disk('public')->delete($product->featured_image);
                }
    
                $filename = $featuredImage->getClientOriginalName();
                $path = "{$product->company->id}/products/";
                $imagePath = "{$path}/{$filename}";
                
                $featuredImage->storeAs($path, $filename, 'public');
                $product->update(['featured_image' => $imagePath]);
            }

            return $product;
        });
    }
}
