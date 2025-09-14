<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'status' => ['required', 'in:pending,confirmed,in_preparation,shipped,delivered,cancelled'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => __('Le statut est requis.'),
            'status.in' => __('Le statut doit être une des valeurs suivantes : :values.'),
        ];
    }
}
