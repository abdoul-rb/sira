<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'countryCode' => ['required', 'string', 'in:CI,GN,SN,FR,ML,MA,BF'],
            'phone_number' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'Le prénom est requis.',
            'lastname.required' => 'Le nom est requis.',
            'email.email' => "L'email doit être une adresse email valide.",
            'countryCode.required' => 'Le code pays est obligatoire.',
            'countryCode.in' => 'Le code pays sélectionné est invalide.',
            'phone_number.required' => 'Le téléphone est requis.',
            'address.string' => "L'adresse doit être une chaîne de caractères.",
        ];
    }
}
