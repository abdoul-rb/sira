<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Rules\UnauthorizedEmailProviders;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterFormRequest extends FormRequest
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
            'name' => 'required|string',
            'countryCode' => 'required|string',
            'phoneNumber' => ['required', 'string', 'unique:users,phone_number', 'max:26'],
            // 'email' => ['nullable', 'email', 'unique:users', 'lowercase', 'max:255', new UnauthorizedEmailProviders],
            'password' => ['required', Password::min(6)/* ->mixedCase() */],
            'terms' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom complet est requis.',
            'phoneNumber.required' => 'Le numéro de téléphone est obligatoire.',
            'countryCode.required' => 'Le code pays est obligatoire.',
            // 'email.unique' => 'Cette adresse email est déjà utilisé',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.mixed_case' => 'Le mot de passe doit contenir au moins une lettre majuscule et une lettre minuscule.',
            'terms.accepted' => "Vous devez accepter les conditions générales d'utilisation.",
        ];
    }
}
