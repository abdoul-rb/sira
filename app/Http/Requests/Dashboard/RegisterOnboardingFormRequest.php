<?php

declare(strict_types=1);

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterOnboardingFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation complètes pour le flow inscription + onboarding.
     * Utilisées lors de la soumission finale (submit) du wizard.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Step 1 — Compte utilisateur
            'name' => 'required|string|max:255',
            'countryCode' => 'required|string|in:CI,GN,SN,ML,BF',
            'phoneNumber' => ['required', 'string', 'unique:users,phone_number', 'max:26'],
            'password' => ['required', Password::min(6)/* ->mixedCase() */],

            // Step 2 — Company
            'companyName' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom complet est requis.',
            'countryCode.required' => 'Le code pays est obligatoire.',
            'phoneNumber.required' => 'Le numéro de téléphone est obligatoire.',
            'phoneNumber.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'password.required' => 'Le mot de passe est requis.',
            'companyName.required' => 'Le nom de la boutique est requis.',
        ];
    }
}
