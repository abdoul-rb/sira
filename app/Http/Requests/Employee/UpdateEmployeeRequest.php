<?php

declare(strict_types=1);

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateEmployeeRequest extends FormRequest
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
            'position' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'hire_date' => ['nullable', 'date'],
            'active' => ['boolean'],
            'can_login' => ['boolean'],
            'email' => ['required_if:can_login,true', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
            'role' => ['required_if:can_login,true', 'string', 'in:employee,manager'],
        ];


        return $rules;
    }

    public function messages(): array
    {
        return [
            'email.required' => "L'email est requis pour un employé qui peut se connecter.",
            'email.unique' => 'Cet email est déjà utilisé par un autre utilisateur.',
            'role.required' => 'Le rôle est requis pour un employé qui peut se connecter.',
            'role.in' => 'Le rôle doit être "employee" ou "manager".',
        ];
    }
}
