<?php

declare(strict_types=1);

use App\Livewire\Dashboard\RegisterOnboardingWizard;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates company and successfully accesses the tenant route', function () {
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => \App\Enums\RoleEnum::MANAGER->value]);

    Livewire::actingAs(User::factory()->create()) // wait, RegisterOnboardingWizard doesn't need actingAs in production but let's test just the submit.
        ->test(RegisterOnboardingWizard::class)
        ->set('name', 'John Doe')
        ->set('phoneNumber', '0707070707')
        ->set('password', 'password123')
        ->call('nextStep')
        ->set('companyName', 'My Mega Company')
        ->call('nextStep')
        ->call('submit');

    $url = url('/my-mega-company/dashboard');
    $response = $this->get($url);
    
    // Dump response status or content if not 200
    if ($response->status() !== 200) {
        dump($response->status(), $response->content());
    }
    
    $response->assertOk();
});
