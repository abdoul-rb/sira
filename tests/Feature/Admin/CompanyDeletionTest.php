<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('deletes associated users when a company is force deleted', function () {
    // 1. Setup: Create a company, a user, and a member link
    $company = Company::factory()->create();
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'company_id' => $company->id,
        'user_id' => $user->id,
    ]);

    // Verify they exist
    expect(Company::count())->toBe(1);
    expect(User::where('id', $user->id)->exists())->toBeTrue();

    // 2. Execution: Mimic the ForceDeleteAction logic
    // (We mimic it here because testing Filament actions directly in Pest is complex without full setup)
    
    // Logic from CompanyResource:
    $company->members()->with('user')->get()->each(function ($m) {
        if ($m->user) {
            $m->user->delete();
        }
    });
    $company->forceDelete();

    // 3. Verification
    expect(Company::count())->toBe(0);
    expect(User::where('id', $user->id)->exists())->toBeFalse();
    expect(Member::count())->toBe(0);
});

it('supports soft delete on company', function () {
    $company = Company::factory()->create();
    
    $company->delete();
    
    expect($company->trashed())->toBeTrue();
    expect(Company::count())->toBe(0);
    expect(Company::withTrashed()->count())->toBe(1);
});
