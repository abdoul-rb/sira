<?php

declare(strict_types=1);

use App\Enums\CustomerType;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use App\Models\Order;
use App\Models\Quotation;

beforeEach(function () {
    $this->company = Company::factory()->create();
});

test('Employee: array expected columns', function () {
    $employee = Employee::factory()->create()->fresh();

    expect(array_keys($employee->toArray()))->toBe([
        'id',
        'uuid',
        'user_id',
        'company_id',
        'position',
        'department',
        'hire_date',
        'active',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

test('Employee: create a employee', function () {
    $employee = Employee::factory()->create()->fresh();

    expect($employee)->toBeInstanceOf(Employee::class)
        ->and($employee->uuid)->not()->toBeNull()
        ->and($employee->active)->toBeTrue();
});

test('Employee: create a inactive employee', function () {
    $employee = Employee::factory()->inactive()->create()->fresh();

    expect($employee->active)->toBeFalse();
});

test('Employee: relation avec User', function () {
    $employee = Employee::factory()->create()->fresh();

    expect($employee->user)->toBeInstanceOf(User::class);
});

test('Employee: relation avec Company', function () {
    $employee = Employee::factory()->create()->fresh();

    expect($employee->company)->toBeInstanceOf(Company::class);
});

// test les scope scopeActive, scopeConnectedEmployees, scopeOfflineEmployees
test('Employee: scope : peut filtrer les employés actifs', function () {
    $activeEmployees = Employee::factory()->count(3)->create()->fresh();
    $inactiveEmployees = Employee::factory()->inactive()->count(2)->create()->fresh();

    $activeEmployees = Employee::active()->get();

    expect($activeEmployees)->toHaveCount(3);
});

test('Employee: scope : peut filtrer les employés connectés', function () {
    $connectedEmployees = Employee::factory()->count(3)->create()->fresh();

    $connectedEmployees = Employee::connectedEmployees()->get();

    expect($connectedEmployees)->toHaveCount(3);
});

test('Employee: scope : peut filtrer les employés nonconnectés', function () {
    Employee::factory()->count(2)->create([
        'user_id' => null,
    ])->fresh();

    $connectedEmployees = Employee::factory()->count(3)->create()->fresh();
    
    $offlineEmployees = Employee::offlineEmployees()->get();

    expect($offlineEmployees)->toHaveCount(2);
});



