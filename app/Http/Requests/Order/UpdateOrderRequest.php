<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'order_number' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:pending,confirmed,in_preparation,shipped,delivered,cancelled'],
            'subtotal' => ['nullable', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'shipping_cost' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'shipping_address' => ['nullable', 'string', 'max:255'],
            'billing_address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists' => __('Le client n\'existe pas.'),
            'quotation_id.exists' => __('La facture n\'existe pas.'),
            'order_number.string' => __('Le numéro de commande doit être une chaîne de caractères.'),
            'order_number.max' => __('Le numéro de commande ne doit pas dépasser 50 caractères.'),
            'status.required' => __('Le statut est requis.'),
            'status.in' => __('Le statut doit être une des valeurs suivantes : :values.'),
            'subtotal.numeric' => __('Le sous-total doit être un nombre.'),
            'subtotal.min' => __('Le sous-total doit être supérieur à 0.'),
            'tax_amount.numeric' => __('Le montant de la taxe doit être un nombre.'),
        ];
    }
}
