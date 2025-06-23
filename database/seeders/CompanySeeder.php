<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'name' => 'Sofa Smart',
            'email' => 'contact@sofasmart.com',
            'phone_number' => '+33600000000',
            'website' => 'https://sofasmart-tech.com',
            'active' => true,
            'logo_path' => null,
            'address' => 'Duékoue - Grande Gare',
            'city' => 'Duékoué',
            'zip_code' => '99000',
            'country' => "Côte d'Ivoire",
        ]);
    }
}
