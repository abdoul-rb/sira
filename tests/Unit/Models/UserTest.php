<?php

declare(strict_types=1);

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Str;

test('User: array expected columns', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toEqualCanonicalizing([
        'id',
        'uuid',
        'name',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

describe('User Model', function () {
    test('peut créer un utilisateur avec les données de base', function () {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        expect($user)
            ->toBeInstanceOf(User::class)
            ->and($user->name)->toBe('John Doe')
            ->and($user->email)->toBe('john@example.com')
            ->and($user->uuid)->not->toBeNull()
            ->and($user->uuid)->toBeInstanceOf(Ramsey\Uuid\Lazy\LazyUuidFromString::class);
    });

    test('casts attributes correctly', function () {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'last_login_at' => now(),
        ]);

        expect($user->email_verified_at)->toBeInstanceOf(\Carbon\Carbon::class)
            ->and($user->last_login_at)->toBeInstanceOf(\Carbon\Carbon::class);
    });

    test('génère un UUID à la création', function () {
        $user = User::factory()->create();

        expect($user->uuid)->not->toBeNull()
            ->and($user->uuid)->toBeInstanceOf(Ramsey\Uuid\Lazy\LazyUuidFromString::class);
    });

    test('peut vérifier si super admin', function () {
        config(['auth.admin_emails' => 'admin@example.com,super@example.com']);

        $admin = User::factory()->create(['email' => 'admin@example.com']);
        $user = User::factory()->create(['email' => 'user@example.com']);

        expect($admin->isSuper())->toBeTrue()
            ->and($user->isSuper())->toBeFalse();
    });

    test('retourne le nom pour Filament', function () {
        $user = User::factory()->create(['name' => 'John Doe']);

        expect($user->getFilamentName())->toBe('John Doe');
    });

    test('génère les initiales correctement', function () {
        $user = User::factory()->create(['name' => 'John Doe']);
        expect($user->initials)->toBe('J');

        $user2 = User::factory()->create(['name' => 'Alice']);
        expect($user2->initials)->toBe('A');
    });

    test('peut avoir un membre associé', function () {
        $user = User::factory()->create();
        $member = Member::factory()->create(['user_id' => $user->id]);

        expect($user->member)->toBeInstanceOf(Member::class)
            ->and($user->member->id)->toBe($member->id);
    });
});
