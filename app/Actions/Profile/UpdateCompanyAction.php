<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class UpdateCompanyAction
{
    public function handle(Company $company, array $data): Company
    {
        return DB::transaction(function () use ($company, $data) {
            $company->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'phone_number' => $data['phoneNumber'],
                'website' => $data['websiteUrl'],
                'address' => $data['address'],
            ]);

            if ($data['logo'] instanceof UploadedFile && !$data['logo']->getError()) {
                if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                    Storage::disk('public')->delete($company->logo);
                }
        
                // Sauver le nouveau fichier
                $path = "companies/{$company->id}";
                $logo =  $data['logo'];
                $filename = $logo->getClientOriginalName();
        
                $savedPath = $logo->storeAs($path, $filename, 'public');
        
                $company->update(['logo_path' => $savedPath]);
            }

            return $company;
        });
    }
}
