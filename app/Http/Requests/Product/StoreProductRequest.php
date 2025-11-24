<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'featuredImage' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'stockQuantity' => 'required|integer',
            'sku' => ['nullable', 'string', 'max:50', 'unique:products,sku'],
            /* 'warehouse_id' => 'nullable|exists:warehouses,id',
            'warehouse_quantity' => 'required|integer|min:1', */
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du produit est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'featuredImage.image' => 'Le fichier doit être une image.',
            'featuredImage.max' => "L'image ne doit pas dépasser 2MB.",
            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix doit être positif.',
            'sku.unique' => 'Le code produit doit être unique.',
            /* 'warehouse_id.required' => "L'entrepôt est obligatoire.",
            'warehouse_id.exists' => "L'entrepôt sélectionné n'existe pas.",
            'warehouse_quantity.required' => 'La quantité est obligatoire.',
            'warehouse_quantity.integer' => 'La quantité doit être un nombre entier.',
            'warehouse_quantity.min' => 'La quantité doit être au moins 1.', */
        ];
    }
}
