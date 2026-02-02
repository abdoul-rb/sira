<?php

declare(strict_types=1);

use App\Models\PwaInstallation;
use App\Models\User;

uses()->group('unit', 'pwa');

describe('platform detection', function () {
    it('detects android platform', function () {
        $userAgent = 'Mozilla/5.0 (Linux; Android 10; SM-G975F) AppleWebKit/537.36';
        expect(PwaInstallation::detectPlatform($userAgent))->toBe('android');
    });

    it('detects ios iphone platform', function () {
        $userAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)';
        expect(PwaInstallation::detectPlatform($userAgent))->toBe('ios');
    });

    it('detects ios ipad platform', function () {
        $userAgent = 'Mozilla/5.0 (iPad; CPU OS 14_0 like Mac OS X)';
        expect(PwaInstallation::detectPlatform($userAgent))->toBe('ios');
    });

    it('detects desktop windows', function () {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
        expect(PwaInstallation::detectPlatform($userAgent))->toBe('desktop');
    });

    it('detects desktop mac', function () {
        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36';
        expect(PwaInstallation::detectPlatform($userAgent))->toBe('desktop');
    });

    it('detects desktop linux', function () {
        $userAgent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36';
        expect(PwaInstallation::detectPlatform($userAgent))->toBe('desktop');
    });

    it('returns unknown for null user agent', function () {
        expect(PwaInstallation::detectPlatform(null))->toBe('unknown');
    });

    it('returns unknown for unrecognized user agent', function () {
        expect(PwaInstallation::detectPlatform('SomeBot/1.0'))->toBe('unknown');
    });
});

describe('device registration', function () {
    it('returns true for existing device', function () {
        $fingerprint = 'test-fingerprint-123';

        PwaInstallation::create([
            'device_fingerprint' => $fingerprint,
            'platform' => 'android',
            'installed_at' => now(),
        ]);

        expect(PwaInstallation::isDeviceRegistered($fingerprint))->toBeTrue();
    });

    it('returns false for non existing device', function () {
        expect(PwaInstallation::isDeviceRegistered('non-existent-fingerprint'))->toBeFalse();
    });

    it('ignores uninstalled devices', function () {
        $fingerprint = 'uninstalled-device';

        PwaInstallation::create([
            'device_fingerprint' => $fingerprint,
            'platform' => 'android',
            'installed_at' => now()->subDays(10),
            'uninstalled_at' => now()->subDays(5),
        ]);

        expect(PwaInstallation::isDeviceRegistered($fingerprint))->toBeFalse();
    });
});

describe('scopes', function () {
    it('active scope excludes uninstalled', function () {
        PwaInstallation::create([
            'device_fingerprint' => 'active-1',
            'platform' => 'android',
            'installed_at' => now(),
        ]);

        PwaInstallation::create([
            'device_fingerprint' => 'uninstalled-1',
            'platform' => 'ios',
            'installed_at' => now()->subDays(10),
            'uninstalled_at' => now(),
        ]);

        expect(PwaInstallation::active()->count())->toBe(1);
    });
});

describe('statistics', function () {
    it('returns correct structure', function () {
        PwaInstallation::create([
            'device_fingerprint' => 'android-1',
            'platform' => 'android',
            'installed_at' => now()->subDays(2),
        ]);

        PwaInstallation::create([
            'device_fingerprint' => 'ios-1',
            'platform' => 'ios',
            'installed_at' => now()->subDays(10),
        ]);

        PwaInstallation::create([
            'device_fingerprint' => 'desktop-1',
            'platform' => 'desktop',
            'installed_at' => now()->subDays(40),
        ]);

        $stats = PwaInstallation::getStats();

        expect($stats)
            ->toHaveKey('total')
            ->toHaveKey('by_platform')
            ->toHaveKey('last_7_days')
            ->toHaveKey('last_30_days');

        expect($stats['total'])->toBe(3);
        expect($stats['last_7_days'])->toBe(1);
        expect($stats['last_30_days'])->toBe(2);
        expect($stats['by_platform'])->toMatchArray([
            'android' => 1,
            'ios' => 1,
            'desktop' => 1,
        ]);
    });
});

describe('relationships', function () {
    it('belongs to user', function () {
        $user = User::factory()->create();

        $installation = PwaInstallation::create([
            'user_id' => $user->id,
            'device_fingerprint' => 'user-device',
            'platform' => 'android',
            'installed_at' => now(),
        ]);

        expect($installation->user)->toBeInstanceOf(User::class);
        expect($installation->user->id)->toBe($user->id);
    });
});
