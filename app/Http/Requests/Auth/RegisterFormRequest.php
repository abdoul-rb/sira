<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'companyName' => ['required', 'string', Rule::unique('companies', 'name')],
            'phoneNumber' => 'required|string',
            'email' => ['required', 'email', 'unique:users', 'lowercase', 'max:255'],
            'password' => ['required', Password::min(6)/* ->mixedCase() */],
            'terms' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'Le prénom est requis.',
            'lastname.required' => 'Le nom est requis.',
            'companyName.required' => "Le nom de l'entreprise est requis.",
            'companyName.unique' => 'Une entreprise avec ce nom existe déjà. Contacter votre administrateur pour rejoindre cette entreprise.',
            'email.required' => "L'adresse email est requise.",
            'email.unique' => 'Cette adresse email est déjà utilisé',
            'phoneNumber.required' => 'Le téléphone est requis.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.mixed_case' => 'Le mot de passe doit contenir au moins une lettre majuscule et une lettre minuscule.',
            'terms.accepted' => "Vous devez accepter les conditions générales d'utilisation.",
        ];
    }
}
