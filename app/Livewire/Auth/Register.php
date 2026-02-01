<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Actions\Auth\RegisterAction;
use App\Http\Requests\Auth\RegisterFormRequest;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $firstname = '';

    /** @var string */
    public $lastname = '';

    /** @var string */
    public $companyName = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $phoneNumber = '';

    /** @var string */
    public $password = '';

    // public $passwordConfirmation = '';

    /** @var bool */
    public $terms = false;

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
        $validated = $this->validate();

        try {
            $user = $action->handle($validated);

            event(new Registered($user));
            Auth::login($user, true);

            $user->load(['member' => function ($query) {
                $query->withoutGlobalScope(\App\Models\Scopes\TenantScope::class);
            }]);

            return redirect()->intended(route('dashboard.index', ['company' => $user->member->company]));
        } catch (Exception $e) {
            Log::error('Registration failed', [
                'email' => $validated['email'],
                'error' => $e->getMessage(),
            ]);

            $this->addError('email', __("Erreur lors de la création de l'utilisateur"));
        }
    }

    public function render()
    {
        // @phpstan-ignore file
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
