<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterAction
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
            $company = Company::firstOrCreate(
                ['name' => $data['companyName']],
                [
                    'email' => $data['email'],
                    'active' => true,
                ]
            );

            $member = $company->members()->create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'phone_number' => $data['phoneNumber'],
            ]);

            $user = User::create([
                'name' => "{$data['firstname']} {$data['lastname']}",
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $member->user()->associate($user);
            $member->save();

            // TODO: Assignation des rôles

            return $user;
        });
    }
}
