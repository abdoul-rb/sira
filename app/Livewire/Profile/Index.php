<?php

declare(strict_types=1);

namespace App\Livewire\Profile;

use App\Actions\Profile\UpdateProfileAction;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Index extends Component
{
    public Company $tenant;

    public User $user;

    public $firstname;

    public $lastname;

    public $email;

    public $phone_number;

    public $current_password;

    public $password;

    public $password_confirmation;

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;

        /** @var User $user */
        $this->user = Auth::user();

        $this->fill([
            'firstname' => $this->user?->member->firstname,
            'lastname' => $this->user?->member->lastname,
            'phone_number' => $this->user?->member->phone_number,
            'email' => $this->user->email,
        ]);
    }

    protected function rules()
    {
        return (new UpdateProfileRequest)->rules();
    }

    protected function messages()
    {
        return (new UpdateProfileRequest)->messages();
    }

    public function update(UpdateProfileAction $action)
    {
        $validated = $this->validate();
        $user = $action->handle($this->user, $validated);

        session()->flash('success', __('Vos infos ont bien été mis à jour'));
    }

    public function updatePassword()
    {
        $validated = Validator::make(
            [
                'current_password' => $this->current_password,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ],
            (new UpdatePasswordRequest)->rules(),
            (new UpdatePasswordRequest)->messages()
        )->validate();

        dd($validated);

        $this->user->update([
            'password' => $validated['password'],
        ]);

        session()->flash('success', __('Le mot de passe à été mis à jour'));
    }

    public function render()
    {
        return view('livewire.profile.index')->extends('layouts.dashboard');
    }
}
