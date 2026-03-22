<?php

declare(strict_types=1);

use App\Actions\Members\CreateOwnerMemberAction;
use App\Models\Company;
use App\Models\User;
use App\Models\Member;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a member from user', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    $company = Company::create(['name' => 'Test', 'country' => 'Test', 'active' => true]);

    $action = new CreateOwnerMemberAction();
    $member = $action->handle($company, $user);

    expect($member)->toBeInstanceOf(Member::class)
        ->and($member->firstname)->toBe('John')
        ->and($member->lastname)->toBe('Doe')
        ->and($member->user_id)->toBe($user->id)
        ->and($member->company_id)->toBe($company->id);
});

it('handles user with no lastname', function () {
    $user = User::factory()->create(['name' => 'Jane']);
    $company = Company::create(['name' => 'Test', 'country' => 'Test', 'active' => true]);

    $action = new CreateOwnerMemberAction();
    $member = $action->handle($company, $user);

    expect($member->firstname)->toBe('Jane')
        ->and($member->lastname)->toBeNull();
});
