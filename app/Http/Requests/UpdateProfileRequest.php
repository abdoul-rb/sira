<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone_number' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'Le prénom est requis.',
            'lastname.required' => 'Le nom est requis.',
            'phone_number.required' => 'Le téléphone est requis.',
            'email.required' => "L'adresse email est requise.",
            'email.unique' => "Cette adresse email est déjà utilisé",
        ];
    }
}
