<?php

declare(strict_types=1);

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'companyLogo' => 'nullable|image|max:2048',
            'companyName' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'shopName' => 'required|string|max:255',
            'shopDescription' => 'nullable|string',
        ];
    }
}
