<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Company $company,
        public string $token
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
            'ctxt' => 'invit',
        ], false));

        return (new MailMessage)
            ->subject(__('Invitation à rejoindre :company', ['company' => $this->company->name]))
            ->greeting(__('Bonjour !'))
            ->line(__('Vous avez été invité à rejoindre l\'équipe de :company sur :app.', [
                'company' => $this->company->name,
                'app' => config('app.name'),
            ]))
            ->line(__('Pour accéder à votre compte, veuillez définir votre mot de passe en cliquant sur le bouton ci-dessous.'))
            ->action(__('Définir mon mot de passe'), $resetUrl)
            ->line(__('Ce lien expirera dans :count minutes.', ['count' => config('auth.passwords.users.expire')]))
            ->line(__('Si vous n\'avez pas demandé cette invitation, vous pouvez ignorer cet email.'))
            ->salutation(__('Cordialement, l\'équipe :app', ['app' => config('app.name')]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'company_id' => $this->company->id,
        ];
    }
}
