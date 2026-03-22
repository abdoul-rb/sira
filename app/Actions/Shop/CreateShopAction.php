<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Models\Company;
use App\Models\Shop;

final class CreateShopAction
{
    public function handle(Company $company, array $data): Shop
    {
        return $company->shop()->create([
            'name' => $data['shopName'],
            'description' => $data['shopDescription'] ?? null,
            'active' => true,
        ]);
    }
}
