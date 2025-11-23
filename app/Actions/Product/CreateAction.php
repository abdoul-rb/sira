<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

final class CreateAction
{
    public function handle(Company $company, array $data): Product
    {
        return DB::transaction(function () use ($company, $data) {
            $product = $company->products()->create([
                'name' => $data['name'],
                'description' => $data['description'],
                'sku' => $data['sku'],
                'price' => $data['price'],
                'stock_quantity' => $data['stock_quantity'],
            ]);

            /** @var UploadedFile|null $featuredImage */
            $featuredImage = $data['featured_image'] ?? null;
    
            if ($featuredImage) {
                $filename = $featuredImage->getClientOriginalName();
                $path = "{$company->id}/products";
                $imagePath = "{$path}/{$filename}";
                
                $featuredImage->storeAs($path, $filename, 'public');
                $product->update(['featured_image' => $imagePath]);
            }

            return $product;
        });
    }
}
