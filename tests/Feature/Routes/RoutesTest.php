<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Member;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('home page can be rendered', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('login page can be rendered', function () {
    $response = $this->get('/auth/login');

    $response->assertStatus(200);
});

test('register page can be rendered', function () {
    $response = $this->get('/auth/register');

    $response->assertStatus(200);
});

test('dashboard requires authentication', function () {
    $company = Company::factory()->create(['slug' => 'test-company']);

    $response = $this->get("/{$company->slug}/dashboard");

    $response->assertRedirect(route('auth.login'));
});

test('dashboard can be accessed by authenticated user', function () {
    $company = Company::factory()->create(['slug' => 'test-company']);
    $user = User::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $response = $this->actingAs($user)->get("/{$company->slug}/dashboard");

    $response->assertStatus(200);
});

test('company route model binding works', function () {
    $company = Company::factory()->create(['name' => 'Nomad Test']);

    // Test that we can find the company by slug (slug is auto-generated from name)
    $foundCompany = Company::where('slug', $company->slug)->first();
    expect($foundCompany)->not->toBeNull();
    expect($foundCompany->id)->toBe($company->id);
    expect($company->slug)->toBe('nomad-test');
});

test('products page requires authentication', function () {
    $company = Company::factory()->create(['slug' => 'test-company']);

    $response = $this->get("/{$company->slug}/dashboard/products");

    $response->assertRedirect(route('auth.login'));
});

test('products page can be accessed by authenticated user', function () {
    $company = Company::factory()->create(['slug' => 'test-company', 'active' => true]);
    $user = User::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $response = $this->actingAs($user)->get("/{$company->slug}/dashboard/products");

    $response->assertStatus(200);
});

test('orders page can be accessed by authenticated user', function () {
    $company = Company::factory()->create(['slug' => 'test-company', 'active' => true]);
    $user = User::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $response = $this->actingAs($user)->get("/{$company->slug}/dashboard/orders");

    $response->assertStatus(200);
});

test('customers page can be accessed by authenticated user', function () {
    $company = Company::factory()->create(['slug' => 'test-company', 'active' => true]);
    $user = User::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $response = $this->actingAs($user)->get("/{$company->slug}/dashboard/customers");

    $response->assertStatus(200);
});

test('settings page can be accessed by authenticated user', function () {
    $company = Company::factory()->create(['slug' => 'test-company', 'active' => true]);
    $user = User::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $response = $this->actingAs($user)->get("/{$company->slug}/dashboard/settings");

    $response->assertStatus(200);
});

test('profile page can be accessed by authenticated user', function () {
    $company = Company::factory()->create(['slug' => 'test-company', 'active' => true]);
    $user = User::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $response = $this->actingAs($user)->get("/{$company->slug}/dashboard/profile");

    $response->assertStatus(200);
});

test('accessing dashboard with invalid company returns 404', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/invalid-company-slug/dashboard');

    $response->assertStatus(404);
});
