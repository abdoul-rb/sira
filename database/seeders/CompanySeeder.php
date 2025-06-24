<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companySofaSmart = Company::where('slug',  Str::slug('Sofa Smart'))->first();
        
        if (!$companySofaSmart) {
            Company::create([
                'name' => 'Sofa Smart',
                'email' => 'contact@sofasmart.com',
                'phone_number' => '+22500000000',
                'website' => 'https://sofasmart-tech.com',
                'active' => true,
                'logo_path' => null,
                'address' => 'Duékoue - Grande Gare',
                'city' => 'Duékoué',
                'zip_code' => '99000',
                'country' => "Côte d'Ivoire",
            ]);
        }

        $companyNomad = Company::where('slug',  Str::slug('Nomad'))->first();

        if (!$companyNomad) {
            Company::create([
                'name' => 'Nomad',
                'email' => 'contact@nomad.com',
                'phone_number' => '+22500000099',
                'website' => 'https://nomad.com',
                'active' => true,
                'logo_path' => null,
                'address' => 'Abidjan - Cocody',
                'city' => 'Abidjan',
                'zip_code' => '99000',
                'country' => "Côte d'Ivoire",
            ]);
        }
    }
}
