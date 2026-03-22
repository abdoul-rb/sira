<?php

declare(strict_types=1);

use App\Actions\Dashboard\CompleteOnboardingAction;
use App\Models\User;
use App\Models\Company;

it('completes onboarding process creating all entities', function () {
    $user = User::factory()->create(['name' => 'Test User']);

    $action = app(CompleteOnboardingAction::class);
    $data = [
        'companyName' => 'Global Corp',
        'country' => 'Canada',
        'shopName' => 'Global Shop',
        'shopDescription' => 'Shop Desc'
    ];

    $company = $action->handle($user, $data);

    expect($company)->toBeInstanceOf(Company::class);
    $this->assertDatabaseHas('companies', ['name' => 'Global Corp']);
    $this->assertDatabaseHas('shops', ['name' => 'Global Shop']);
    
    $this->assertDatabaseHas('members', [
        'company_id' => $company->id,
        'user_id' => $user->id,
        'firstname' => 'Test',
        'lastname' => 'User'
    ]);
});
