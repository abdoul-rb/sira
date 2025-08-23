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
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'featured_image' => ['nullable', 'image'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis',
            'name.string' => 'Le nom doit être une chaîne de caractères',
            'name.max' => 'Le nom ne doit pas dépasser 100 caractères',
            'description.string' => 'La description doit être une chaîne de caractères',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères',
            'featured_image.image' => "L'image doit être une image",
            'featured_image.max' => "L'image ne doit pas dépasser 1024 caractères",
            'price.required' => 'Le prix est requis',
            'price.numeric' => 'Le prix doit être un nombre',
            'price.min' => 'Le prix doit être supérieur à 0',
        ];
    }
}
