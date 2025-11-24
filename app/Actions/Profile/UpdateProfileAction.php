<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateProfileAction
{
    /**
     * Met à jour les informations de profile de l'utilisateur membre.
     *
     * @param  User  $user  L'utilisateur.
     * @param  array  $data  The data for the new user.
     * @return User The newly created user.
     */
    public function handle(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $user->update([
                'name' => "{$data['firstname']} {$data['lastname']}",
                'email' => $data['email'],
            ]);

            $user->member->update([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'phone_number' => $data['phone_number'],
            ]);

            return $user;
        });
    }
}
