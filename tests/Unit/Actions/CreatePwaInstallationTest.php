<?php

declare(strict_types=1);

use App\Actions\CreatePwaInstallation;
use App\Models\Company;
use App\Models\Member;
use App\Models\PwaInstallation;
use App\Models\User;
use Illuminate\Http\Request;

uses()->group('unit', 'actions');

beforeEach(function () {
    $this->action = new CreatePwaInstallation();
});

it('creates installation with fingerprint', function () {
    $request = Request::create('/api/pwa-installations', 'POST', [
        'device_fingerprint' => 'test-fingerprint',
    ]);
    $request->headers->set('User-Agent', 'Mozilla/5.0 (Android 10)');

    $installation = $this->action->handle($request);

    expect($installation)
        ->not->toBeNull()
        ->device_fingerprint->toBe('test-fingerprint')
        ->platform->toBe('android')
        ->installed_at->not->toBeNull();
});

it('returns null for duplicate fingerprint', function () {
    $fingerprint = 'duplicate-fp';

    PwaInstallation::create([
        'device_fingerprint' => $fingerprint,
        'platform' => 'android',
        'installed_at' => now(),
    ]);

    $request = Request::create('/api/pwa-installations', 'POST', [
        'device_fingerprint' => $fingerprint,
    ]);

    $result = $this->action->handle($request);

    expect($result)->toBeNull();
});

it('associates with authenticated user', function () {
    $user = User::factory()->create();
    $company = Company::factory()->create();
    Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);

    $this->actingAs($user);

    $request = Request::create('/api/pwa-installations', 'POST', [
        'device_fingerprint' => 'user-device-fp',
    ]);

    $installation = $this->action->handle($request);

    expect($installation)
        ->not->toBeNull()
        ->user_id->toBe($user->id);
});

it('creates installation without user when not authenticated', function () {
    $request = Request::create('/api/pwa-installations', 'POST', [
        'device_fingerprint' => 'anonymous-device',
    ]);

    $installation = $this->action->handle($request);

    expect($installation)
        ->not->toBeNull()
        ->user_id->toBeNull();
});

it('stores ip address', function () {
    $request = Request::create('/api/pwa-installations', 'POST', [
        'device_fingerprint' => 'ip-test-device',
    ], [], [], ['REMOTE_ADDR' => '192.168.1.100']);

    $installation = $this->action->handle($request);

    expect($installation)
        ->not->toBeNull()
        ->ip_address->toBe('192.168.1.100');
});

it('stores user agent', function () {
    $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Test Browser';

    $request = Request::create('/api/pwa-installations', 'POST', [
        'device_fingerprint' => 'ua-test-device',
    ]);
    $request->headers->set('User-Agent', $userAgent);

    $installation = $this->action->handle($request);

    expect($installation)
        ->not->toBeNull()
        ->user_agent->toBe($userAgent);
});
