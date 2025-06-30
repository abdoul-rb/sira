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
            'customer_id' => ['nullable', 'exists:customers,id'],
            'quotation_id' => ['nullable', 'exists:quotations,id'],
            'status' => ['required', 'in:pending,confirmed,in_preparation,shipped,delivered,cancelled'],
            'shipping_cost' => ['nullable', 'numeric', 'min:0'],
            'shipping_address' => ['nullable', 'string', 'max:255'],
            'billing_address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists' => __("Le client n'existe pas."),
            'quotation_id.exists' => __("La facture n'existe pas."),
            'status.required' => __("Le statut est requis."),
            'status.in' => __("Le statut doit être une des valeurs suivantes : :values."),
        ];
    }
}
