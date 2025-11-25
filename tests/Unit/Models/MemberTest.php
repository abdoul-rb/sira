<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Member;
use App\Models\User;

beforeEach(function () {
    $this->company = Company::factory()->create();
});

test('Member: array expected columns', function () {
    $member = Member::factory()->create()->fresh();

    expect(array_keys($member->toArray()))->toBe([
        'id',
        'uuid',
        'user_id',
        'company_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'firstname',
        'lastname',
        'phone_number',
    ]);
});

test('Member: create a member', function () {
    $member = Member::factory()->create()->fresh();

    expect($member)->toBeInstanceOf(Member::class)
        ->and($member->uuid)->not()->toBeNull();
});

test('Member: relation avec User', function () {
    $member = Member::factory()->create()->fresh();

    expect($member->user)->toBeInstanceOf(User::class);
});

test('Member: relation avec Company', function () {
    $member = Member::factory()->create()->fresh();

    expect($member->company)->toBeInstanceOf(Company::class);
});



