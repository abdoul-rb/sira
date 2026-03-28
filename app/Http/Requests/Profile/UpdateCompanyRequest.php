<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2MB
            'facebookUrl' => ['nullable', 'url', 'max:255'],
            'instagramUrl' => ['nullable', 'url', 'max:255'],
            'tiktokUrl' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Le nom de l'entreprise est obligatoire.",
            'logo.image' => 'Le logo doit être une image valide.',
            'logo.mimes' => 'Formats acceptés : jpg, jpeg, png, webp.',
            'logo.max' => 'Le logo ne peut pas dépasser 2 Mo.',
            'facebookUrl.url' => "L'URL Facebook n'est pas valide.",
            'instagramUrl.url' => "L'URL Instagram n'est pas valide.",
            'tiktokUrl.url' => "L'URL TikTok n'est pas valide.",
        ];
    }
}
