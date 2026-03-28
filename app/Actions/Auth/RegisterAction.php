<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class RegisterAction
{
    /**
     * Gère la logique métier de la création d'un nouvel utilisateur.
     *
     * @param  array  $data  The data for the new user.
     * @return User The newly created user.
     */
    public function handle(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'phone_number' => $data['phoneNumber'] ?? null,
                // 'email' => $data['email'] ?? null,
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole([RoleEnum::MANAGER]);

            return $user;
        });
    }
}
