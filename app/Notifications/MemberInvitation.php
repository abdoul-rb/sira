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
        public string $setupUrl
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
        return (new MailMessage)
            ->subject('Invitation à rejoindre ' . $this->company->name)
            ->greeting('Bonjour !')
            ->line("Vous avez été invité à rejoindre l'équipe de {$this->company->name}.")
            ->line('Pour commencer à utiliser la plateforme, vous devez définir votre mot de passe.')
            ->action('Définir mon mot de passe', $this->setupUrl)
            ->line('Ce lien est valable pendant 7 jours.')
            ->line("Si vous n'avez pas demandé cette invitation, vous pouvez ignorer cet email.")
            ->salutation("Cordialement, l'équipe {$this->company->name}");
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
            'setup_url' => $this->setupUrl,
        ];
    }
}
