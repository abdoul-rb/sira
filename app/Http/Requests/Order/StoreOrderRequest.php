<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        dd('ok');
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
            'customer_id' => 'required|exists:customers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'status' => 'required|in:pending,confirmed,in_preparation,shipped,delivered,cancelled',
            'payment_status' => 'required|in:cash,mobile-money,credit',
            'discount' => 'nullable|numeric|min:0',
            'advance' => 'nullable|numeric|min:0',
            'productLines.*.product_id' => 'required|exists:products,id',
            'productLines.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => __('Le client est requis.'),
            'customer_id.exists' => __("Le client n'existe pas."),
            'warehouse_id.exists' => __("L'entrepôt n'existe pas."),
            'status.required' => __('Le statut est requis.'),
            'status.in' => __('Le statut doit être une des valeurs suivantes : :values.'),
            'payment_status.required' => __('Le mode de paiement est requis.'),
            'payment_status.in' => __('Le mode de paiement doit être une des valeurs suivantes : :values.'),
            'discount.numeric' => __('La remise doit être un nombre.'),
            'discount.min' => __('La remise doit être supérieur à 0.'),
            'advance.numeric' => __("L'avance doit être un nombre."),
            'advance.min' => __("L'avance doit être supérieur à 0."),
            'productLines.*.product_id.required' => __('Le produit est requis.'),
            'productLines.*.product_id.exists' => __("Le produit n'existe pas."),
            'productLines.*.quantity.required' => __('La quantité est requise.'),
            'productLines.*.quantity.integer' => __('La quantité doit être un nombre entier.'),
            'productLines.*.quantity.min' => __('La quantité doit être supérieur à 0.'),
        ];
    }
}
