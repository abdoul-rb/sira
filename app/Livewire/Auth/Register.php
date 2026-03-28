<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Actions\Auth\RegisterAction;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Livewire\Traits\ManagesPhoneNumbers;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    use ManagesPhoneNumbers;

    public string $name = '';

    // public string $email = '';

    public string $phoneNumber = '';

    public string $countryCode = 'CI';

    public string $password = '';

    // public $passwordConfirmation = '';

    public bool $terms = true;

    protected function rules(): array
    {
        return (new RegisterFormRequest)->rules();
    }

    protected function messages(): array
    {
        return (new RegisterFormRequest)->messages();
    }

    public function register(RegisterAction $action)
    {
        $originalPhoneNumber = $this->phoneNumber;

        if (! empty($this->phoneNumber)) {
            $this->phoneNumber = $this->formatToE164($this->phoneNumber, $this->countryCode);
        }

        try {
            $validated = $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->phoneNumber = $originalPhoneNumber;
            throw $e;
        }

        unset($validated['countryCode']);

        try {
            $user = $action->handle($validated);

            event(new Registered($user));
            Auth::login($user, true);

            // Pas de tenant existant encore, on redirige vers l'index pour onboarder
            return redirect()->intended(route('dashboard.onboarding'));
        } catch (Exception $e) {
            $this->phoneNumber = $originalPhoneNumber;

            Log::error('Registration failed', [
                // 'email' => $validated['email'],
                'phoneNumber' => $validated['phoneNumber'],
                'error' => $e->getMessage(),
            ]);

            $this->addError('phoneNumber', __("Erreur lors de la création de l'utilisateur"));
        }
    }

    public function render()
    {
        // @phpstan-ignore file
        return view('livewire.auth.register');
    }
}
