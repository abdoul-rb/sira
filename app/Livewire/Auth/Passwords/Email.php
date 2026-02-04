<?php

declare(strict_types=1);

namespace App\Livewire\Auth\Passwords;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Email extends Component
{
    public string $email = '';

    /** @var string|null */
    public string|bool $emailSentMessage = false;

    public function sendResetPasswordLink()
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $response = $this->broker()->sendResetLink(['email' => $this->email]);

        if ($response == Password::RESET_LINK_SENT) {
            $this->emailSentMessage = trans($response);

            return;
        }

        $this->addError('email', trans($response));
    }

    /**
     * Get the broker to be used during password reset.
     */
    public function broker(): PasswordBroker
    {
        return Password::broker();
    }

    public function render()
    {
        return view('livewire.auth.passwords.email');
    }
}
