<?php

declare(strict_types=1);

use App\Actions\Company\CreateCompanyAction;
use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a company without logo', function () {
    $action = new CreateCompanyAction();
    $data = [
        'companyName' => 'Test Company',
        'country' => 'Senegal'
    ];

    $company = $action->handle($data);

    expect($company)->toBeInstanceOf(Company::class)
        ->and($company->name)->toBe('Test Company')
        ->and($company->country)->toBe('Senegal')
        ->and($company->active)->toBeTrue()
        ->and($company->logo_path)->toBeNull();

    $this->assertDatabaseHas('companies', ['name' => 'Test Company']);
});

it('creates a company with logo', function () {
    Storage::fake('public');

    $action = new CreateCompanyAction();
    $data = [
        'companyName' => 'Logo Company',
        'country' => 'Mali'
    ];
    $file = UploadedFile::fake()->image('logo.jpg');

    $company = $action->handle($data, $file);

    expect($company->logo_path)->not->toBeNull();
    Storage::disk('public')->assertExists($company->logo_path);
});
