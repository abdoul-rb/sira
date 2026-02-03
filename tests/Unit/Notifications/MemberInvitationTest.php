<?php

declare(strict_types=1);

use App\Models\Company;
use App\Models\User;
use App\Notifications\MemberInvitation;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses()->group('unit', 'notifications');

it('sends member invitation with password reset token', function () {
    Notification::fake();

    $company = Company::factory()->create();
    $user = User::factory()->create();

    // Generate token like the Create component does
    $token = Password::broker()->createToken($user);

    $user->notify(new MemberInvitation($company, $token));

    Notification::assertSentTo($user, MemberInvitation::class, function ($notification) use ($company, $token) {
        expect($notification->company->id)->toBe($company->id);
        expect($notification->token)->toBe($token);

        return true;
    });
});

it('generates reset password link in email', function () {
    $company = Company::factory()->create(['name' => 'Acme Corp']);
    $user = User::factory()->create(['email' => 'test@example.com']);

    $token = Password::broker()->createToken($user);
    $notification = new MemberInvitation($company, $token);

    $mail = $notification->toMail($user);

    expect($mail->subject)->toContain('Acme Corp');
    expect($mail->actionUrl)->toContain('/password/reset/' . $token);
    expect($mail->actionUrl)->toContain('email=test%40example.com');
    expect($mail->actionUrl)->toContain('ctxt=invit');
});

it('includes company name in email content', function () {
    $company = Company::factory()->create(['name' => 'Super Boutique']);
    $user = User::factory()->create();

    $token = 'fake-token';
    $notification = new MemberInvitation($company, $token);

    $mail = $notification->toMail($user);

    // Check that introLines contain company name
    $content = implode(' ', $mail->introLines);
    expect($content)->toContain('Super Boutique');
});
