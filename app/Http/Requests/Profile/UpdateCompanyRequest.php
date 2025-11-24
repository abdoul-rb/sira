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
            'description' => ['nullable', 'string'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'websiteUrl' => ['nullable', 'url', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Le nom de l'entreprise est obligatoire.",
            'logo.image' => 'Le logo doit être une image valide.',
            'logo.mimes' => 'Formats acceptés : jpg, jpeg, png, webp.',
            'logo.max' => 'Le logo ne peut pas dépasser 2 Mo.',
            'websiteUrl.url' => "L'URL du site web doit être valide.",
        ];
    }
}
