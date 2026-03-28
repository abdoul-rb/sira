<?php

declare(strict_types=1);

use App\Livewire\Dashboard\RegisterOnboardingWizard;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

it('opens automatically on the onboarding page', function () {
    $this->get(route('dashboard.onboarding'))
        ->assertOk()
        ->assertSeeLivewire(RegisterOnboardingWizard::class);
});

it('validates step 1 required fields', function () {
    Livewire::test(RegisterOnboardingWizard::class)
        ->call('nextStep')
        ->assertHasErrors(['name', 'phoneNumber', 'password']);
});


it('validates phone number uniqueness on step 1', function () {
    User::factory()->create(['phone_number' => '+2250102030405']);

    Livewire::test(RegisterOnboardingWizard::class)
        ->set('name', 'Test User')
        ->set('countryCode', 'CI')
        ->set('phoneNumber', '+2250102030405')
        ->set('password', 'secret')
        ->call('nextStep')
        ->assertHasErrors(['phoneNumber']);
});

it('moves to step 2 when step 1 is valid', function () {
    Livewire::test(RegisterOnboardingWizard::class)
        ->set('name', 'Aminata Koné')
        ->set('countryCode', 'CI')
        ->set('phoneNumber', '+2250102030405')
        ->set('password', 'secret123')
        ->call('nextStep')
        ->assertSet('step', 2)
        ->assertHasNoErrors();
});

it('saves data to cache between steps', function () {
    $component = Livewire::test(RegisterOnboardingWizard::class)
        ->set('name', 'Aminata Koné')
        ->set('countryCode', 'SN')
        ->set('phoneNumber', '+2210102030405')
        ->set('password', 'secret123')
        ->call('nextStep');

    $cached = Cache::get('onboarding:' . session()->getId());

    expect($cached)->not->toBeNull()
        ->and($cached['step'])->toBe(2)
        ->and($cached['name'])->toBe('Aminata Koné');
});

it('goes back to step 1 with prevStep', function () {
    Livewire::test(RegisterOnboardingWizard::class)
        ->set('name', 'Aminata Koné')
        ->set('countryCode', 'CI')
        ->set('phoneNumber', '+2250102030405')
        ->set('password', 'secret123')
        ->call('nextStep')
        ->assertSet('step', 2)
        ->call('prevStep')
        ->assertSet('step', 1);
});

it('creates user, company and member on submit', function () {
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => \App\Enums\RoleEnum::MANAGER->value]);

    Livewire::test(RegisterOnboardingWizard::class)
        ->set('name', 'Aminata Koné')
        ->set('countryCode', 'CI')
        ->set('phoneNumber', '+2250102030405')
        ->set('password', 'secret123')
        ->call('nextStep')
        ->set('companyName', 'Boutique Aminata')
        ->call('submit')
        ->assertRedirect();

    $this->assertDatabaseHas('users', ['phone_number' => '+2250102030405']);
    $this->assertDatabaseHas('companies', [
        'name'    => 'Boutique Aminata',
        'country' => "Côte d'Ivoire",
    ]);

    $company = Company::where('name', 'Boutique Aminata')->first();
    $user = User::where('phone_number', '+2250102030405')->first();

    $this->assertDatabaseHas('members', [
        'company_id' => $company->id,
        'user_id'    => $user->id,
    ]);
});

it('clears cache after successful submission', function () {
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => \App\Enums\RoleEnum::MANAGER->value]);

    Livewire::test(RegisterOnboardingWizard::class)
        ->set('name', 'Test User')
        ->set('countryCode', 'CI')
        ->set('phoneNumber', '+2250109876543')
        ->set('password', 'secret123')
        ->call('nextStep')
        ->set('companyName', 'Ma Boutique')
        ->call('submit');

    expect(Cache::get('onboarding:' . session()->getId()))->toBeNull();
});

it('deconstructs phone number when going back to step 1', function () {
    Livewire::test(RegisterOnboardingWizard::class)
        ->set('name', 'Aminata Koné')
        ->set('countryCode', 'CI')
        ->set('phoneNumber', '0102030405')
        ->set('password', 'secret123')
        ->call('nextStep')
        ->assertHasNoErrors()
        ->assertSet('step', 2)
        ->assertSet('phoneNumber', '+2250102030405')
        ->call('prevStep')
        ->assertSet('step', 1)
        ->assertSet('phoneNumber', '0102030405') // Doit être revenu au format local sans espaces
        ->assertSet('countryCode', 'CI');
});
