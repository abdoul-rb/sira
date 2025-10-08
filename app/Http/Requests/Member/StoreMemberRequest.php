<?php

declare(strict_types=1);

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreMemberRequest extends FormRequest
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
        $rules = [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phoneNumber' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email'],
            // 'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'firstname.required' => "Le nom est obligatoire",
            'lastname.required' => "Le prénom est obligatoire",
        ];
    }
}
