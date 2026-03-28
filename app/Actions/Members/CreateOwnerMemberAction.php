<?php

declare(strict_types=1);

namespace App\Actions\Members;

use App\Models\Company;
use App\Models\Member;
use App\Models\User;

final class CreateOwnerMemberAction
{
    public function handle(Company $company, User $user): Member
    {
        $parts = explode(' ', $user->name ?? '', 2);
        $firstname = $parts[0] ?: 'User';
        $lastname = $parts[1] ?? null;

        $member = $company->members()->create([
            'firstname' => $firstname,
            'lastname' => $lastname,
        ]);

        $member->user()->associate($user);
        $member->save();

        return $member;
    }
}
