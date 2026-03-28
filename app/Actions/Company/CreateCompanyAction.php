<?php

declare(strict_types=1);

namespace App\Actions\Company;

use App\Models\Company;

final class CreateCompanyAction
{
    public function handle(array $data, $companyLogo = null): Company
    {
        $companyPath = $companyLogo ? $companyLogo->store('companies/logos', 'public') : null;

        return Company::create([
            'name' => $data['companyName'],
            'country' => $data['country'],
            'logo_path' => $companyPath,
            'active' => true,
        ]);
    }
}
