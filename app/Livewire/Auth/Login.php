<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();

        // Tentative de connexion
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        $user = Auth::user();
        $tenantSlug = request()->route('tenant'); // route->parameter('tenant')

        // Récupérer la company du tenant depuis la route (injectée par le middleware)
        $company = Company::where('slug', $tenantSlug)->first();

        // Vérifier que l'utilisateur appartient à cette company ou est super admin
        if (! $user->isSuperAdmin() && $user->company_id !== $company->id) {
            Auth::logout();
            $this->addError('email', 'Access denied');

            return;
        }

        // Redirection vers le dashboard du tenant
        return redirect()->intended(route('dashboard.index', ['tenant' => $tenantSlug]));
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
