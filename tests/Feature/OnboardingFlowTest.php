<?php

declare(strict_types=1);

use App\Livewire\Dashboard\OnboardingWizard;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('allows user without company to access onboarding dashboard', function () {
    // Avec le middleware guest, un visiteur non connecté peut accéder à la page
    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});

it('redirects authenticated user away from onboarding page', function () {
    // Avec le middleware guest, un utilisateur connecté est redirigé
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(302);
});

it('caches data between steps in onboarding wizard', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(OnboardingWizard::class)
        ->set('companyName', 'My Test Company')
        ->set('country', 'Sénégal')
        ->call('nextStep')
        ->assertSet('step', 2);

    $cache = Cache::get('onboarding:' . $user->id);
    expect($cache['companyName'])->toBe('My Test Company')
        ->and($cache['step'])->toBe(2);
});

it('creates company and redirects upon onboarding completion', function () {
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => \App\Enums\RoleEnum::MANAGER->value]);

    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(OnboardingWizard::class)
        // Step 1
        ->set('companyName', 'My Final Company')
        ->set('country', 'Senegal')
        ->call('nextStep')
        // Step 2 (shopName n'est plus requis mais le champ doit être setté)
        ->set('shopName', 'My Final Company')
        ->call('nextStep')
        // Step 3
        ->call('submit')
        ->assertRedirect();

    $this->assertDatabaseHas('companies', ['name' => 'My Final Company']);

    $company = Company::where('name', 'My Final Company')->first();

    $this->assertDatabaseHas('members', [
        'company_id' => $company->id,
        'user_id' => $user->id,
    ]);

    expect(Cache::get('onboarding:' . $user->id))->toBeNull();
});
