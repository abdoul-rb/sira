<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Member;
use App\Models\PwaInstallation;
use App\Models\User;

uses()->group('api', 'pwa');

it('can track pwa installation', function () {
    $fingerprint = hash('sha256', 'test-device-fingerprint');

    $response = $this->postJson('/api/pwa-installations', [
        'device_fingerprint' => $fingerprint,
    ]);

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'already_registered' => false,
        ]);

    $this->assertDatabaseHas('pwa_installations', [
        'device_fingerprint' => $fingerprint,
        'platform' => 'unknown',
    ]);
});

it('tracks platform from user agent', function () {
    $fingerprint = hash('sha256', 'android-device');

    $response = $this->postJson('/api/pwa-installations', [
        'device_fingerprint' => $fingerprint,
    ], [
        'User-Agent' => 'Mozilla/5.0 (Linux; Android 10) AppleWebKit/537.36',
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('pwa_installations', [
        'device_fingerprint' => $fingerprint,
        'platform' => 'android',
    ]);
});

it('detects ios platform', function () {
    $fingerprint = hash('sha256', 'ios-device');

    $response = $this->postJson('/api/pwa-installations', [
        'device_fingerprint' => $fingerprint,
    ], [
        'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)',
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('pwa_installations', [
        'device_fingerprint' => $fingerprint,
        'platform' => 'ios',
    ]);
});

it('detects desktop platform', function () {
    $fingerprint = hash('sha256', 'desktop-device');

    $response = $this->postJson('/api/pwa-installations', [
        'device_fingerprint' => $fingerprint,
    ], [
        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('pwa_installations', [
        'device_fingerprint' => $fingerprint,
        'platform' => 'desktop',
    ]);
});

it('prevents duplicate installation registration', function () {
    $fingerprint = hash('sha256', 'duplicate-device');

    // First registration
    $this->postJson('/api/pwa-installations', [
        'device_fingerprint' => $fingerprint,
    ])->assertOk();

    // Second registration - should indicate already registered
    $response = $this->postJson('/api/pwa-installations', [
        'device_fingerprint' => $fingerprint,
    ]);

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'already_registered' => true,
        ]);

    // Should only have one record
    $this->assertDatabaseCount('pwa_installations', 1);
});

it('can check if device is registered', function () {
    $fingerprint = hash('sha256', 'check-device');

    // Not registered yet
    $response = $this->postJson('/api/pwa-installations/check', [
        'device_fingerprint' => $fingerprint,
    ]);

    $response->assertOk()
        ->assertJson(['registered' => false]);

    // Register the device
    PwaInstallation::create([
        'device_fingerprint' => $fingerprint,
        'platform' => 'android',
        'installed_at' => now(),
    ]);

    // Now should be registered
    $response = $this->postJson('/api/pwa-installations/check', [
        'device_fingerprint' => $fingerprint,
    ]);

    $response->assertOk()
        ->assertJson(['registered' => true]);
});

it('check returns false for empty fingerprint', function () {
    $response = $this->postJson('/api/pwa-installations/check', [
        'device_fingerprint' => null,
    ]);

    $response->assertOk()
        ->assertJson(['registered' => false]);
});

it('associates installation with authenticated user', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $fingerprint = hash('sha256', 'user-device');

    $response = $this->actingAs($user)->postJson('/api/pwa-installations', [
        'device_fingerprint' => $fingerprint,
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('pwa_installations', [
        'device_fingerprint' => $fingerprint,
        'user_id' => $user->id,
    ]);
});

it('stats endpoint requires authentication', function () {
    $response = $this->getJson('/api/pwa-installations/stats');

    $response->assertUnauthorized();
});

it('authenticated user can get stats', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    // Create some installations
    PwaInstallation::create([
        'platform' => 'android',
        'device_fingerprint' => 'fp1',
        'installed_at' => now(),
    ]);
    PwaInstallation::create([
        'platform' => 'ios',
        'device_fingerprint' => 'fp2',
        'installed_at' => now(),
    ]);

    $response = $this->actingAs($user)->getJson('/api/pwa-installations/stats');

    $response->assertOk()
        ->assertJsonStructure([
            'success',
            'stats' => [
                'total',
                'by_platform',
                'last_7_days',
                'last_30_days',
            ],
        ]);

    expect($response->json('stats.total'))->toBe(2);
});
