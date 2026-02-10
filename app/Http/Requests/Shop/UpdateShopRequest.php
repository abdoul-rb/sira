<?php

declare(strict_types=1);

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
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
            'description' => 'nullable|string|max:1000',
            'facebookUrl' => 'nullable|url|max:255',
            'instagramUrl' => 'nullable|url|max:255',
            'newLogo' => 'nullable|image|max:1024', // 1MB max
            'active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la boutique est requis.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
            'facebookUrl.url' => "L'URL Facebook n'est pas valide.",
            'instagramUrl.url' => "L'URL Instagram n'est pas valide.",
            'newLogo.image' => 'Le fichier doit être une image.',
            'newLogo.max' => "L'image ne peut pas dépasser 1MB.",
        ];
    }
}
