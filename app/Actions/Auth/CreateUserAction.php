<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class CreateUserAction
{
    public function handle(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'phone_number' => $data['phoneNumber'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole([RoleEnum::MANAGER]);

        return $user;
    }
}
