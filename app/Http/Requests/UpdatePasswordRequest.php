<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => ['required', new CurrentPassword],
            'password' => ['required', Password::min(6)/* ->mixedCase() */, 'confirmed'],
            'password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Le mot de passe actuel est obligatoire',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.confirmed' => 'Les deux mots de passe ne sont pas identique',
            'password_confirmation.required' => 'La confirmation de mot de passe est obligatoire',
        ];
    }
}
