<?php

declare(strict_types=1);

namespace App\Actions\Members;

use App\Enums\RoleEnum;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateMemberAction
{
    /**
     * Gère la logique métier de la création d'un nouveau membre d'une entreprise.
     *
     * @param  array  $data  The data for the new user.
     * @return Member The newly created user.
     */
    public function handle(array $data): Member
    {
        return DB::transaction(function () use ($data) {
            $member = Member::create([
                'company_id' => $data['company_id'],
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'phone_number' => $data['phoneNumber'],
            ]);

            $user = User::create([
                'name' => "{$data['firstname']} {$data['lastname']}",
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole([RoleEnum::OPERATOR]);

            $member->user()->associate($user);
            $member->save();

            return $member;
        });
    }
}
