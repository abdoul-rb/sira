<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Notifications\MemberInvitation;
use Illuminate\Support\Facades\Password;

final class InvitationService
{
    /**
     * Send an invitation email to a user to set their password.
     *
     * @param  User  $user  The user to invite
     * @param  Company  $company  The company the user is being invited to
     */
    public function sendInvitation(User $user, Company $company): void
    {
        // Generate a password reset token
        $token = Password::broker()->createToken($user);

        // Send the invitation notification
        $user->notify(new MemberInvitation($company, $token));
    }
}
