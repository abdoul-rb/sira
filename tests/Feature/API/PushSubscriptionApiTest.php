<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\Member;
use App\Models\User;

uses()->group('api', 'push');

it('push subscription requires authentication', function () {
    $response = $this->postJson('/api/push-subscriptions', [
        'endpoint' => 'https://push.example.com/123',
        'keys' => [
            'p256dh' => 'test-p256dh-key',
            'auth' => 'test-auth-key',
        ],
    ]);

    $response->assertUnauthorized();
});

it('authenticated user can save push subscription', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $endpoint = 'https://push.example.com/' . uniqid();

    $response = $this->actingAs($user)->postJson('/api/push-subscriptions', [
        'endpoint' => $endpoint,
        'keys' => [
            'p256dh' => 'test-p256dh-key-' . uniqid(),
            'auth' => 'test-auth-key-' . uniqid(),
        ],
    ]);

    $response->assertOk()
        ->assertJson(['success' => true]);

    $this->assertDatabaseHas('push_subscriptions', [
        'subscribable_id' => $user->id,
        'subscribable_type' => User::class,
        'endpoint' => $endpoint,
    ]);
});

it('can update existing subscription', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $endpoint = 'https://push.example.com/' . uniqid();
    $newP256dh = 'new-p256dh-key-' . uniqid();

    // Initial subscription
    $this->actingAs($user)->postJson('/api/push-subscriptions', [
        'endpoint' => $endpoint,
        'keys' => [
            'p256dh' => 'old-p256dh-key',
            'auth' => 'old-auth-key',
        ],
    ]);

    // Update subscription
    $response = $this->actingAs($user)->postJson('/api/push-subscriptions', [
        'endpoint' => $endpoint,
        'keys' => [
            'p256dh' => $newP256dh,
            'auth' => 'new-auth-key',
        ],
    ]);

    $response->assertOk();

    // Should only have one subscription for this endpoint
    $subscriptions = $user->pushSubscriptions()->where('endpoint', $endpoint)->get();

    expect($subscriptions)->toHaveCount(1);
    expect($subscriptions->first()->public_key)->toBe($newP256dh);
});

it('can delete push subscription', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $endpoint = 'https://push.example.com/' . uniqid();

    // Create subscription first
    $this->actingAs($user)->postJson('/api/push-subscriptions', [
        'endpoint' => $endpoint,
        'keys' => [
            'p256dh' => 'test-p256dh',
            'auth' => 'test-auth',
        ],
    ]);

    // Delete it
    $response = $this->actingAs($user)->deleteJson('/api/push-subscriptions', [
        'endpoint' => $endpoint,
    ]);

    $response->assertOk()
        ->assertJson(['success' => true]);

    $this->assertDatabaseMissing('push_subscriptions', [
        'subscribable_id' => $user->id,
        'endpoint' => $endpoint,
    ]);
});

it('delete requires authentication', function () {
    $response = $this->deleteJson('/api/push-subscriptions', [
        'endpoint' => 'https://push.example.com/123',
    ]);

    $response->assertUnauthorized();
});
