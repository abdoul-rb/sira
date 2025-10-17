<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
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
            'supplierId' => ['required', 'integer', 'exists:suppliers,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'details' => ['nullable', 'string', 'max:1000'],
            'purchasedAt' => ['required', 'date']
        ];
    }

    public function messages(): array
    {
        return [
            'supplierId.required' => 'Le fournisseur est obligatoire.',
            'supplierId.exists' => "Le fournisseur sélectionné n'existe pas.",
            'amount.required' => 'Le montant est obligatoire.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant doit être supérieur ou égal à 0.',
            'details.string' => 'Les détails doivent être du texte.',
            'details.max' => 'Les détails ne peuvent pas dépasser 1000 caractères.',
            'purchasedAt.required' => "La date d'achat est obligatoire.",
            'purchasedAt.date' => "La date d'achat doit être une date valide.",
        ];
    }
}
