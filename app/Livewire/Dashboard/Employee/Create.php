<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Employee;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\EmployeeInvitation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public Company $tenant;

    public $firstname = '';

    public $lastname = '';

    public $phone_number = '';

    public $position = '';

    public $department = '';

    public $hire_date = '';

    public $active = true;

    public $can_login = false;

    // Champs utilisateur (conditionnels)
    public $email = '';

    public $role = 'employee';

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    protected function rules(): array
    {
        return (new StoreEmployeeRequest)->rules();
    }

    protected function messages(): array
    {
        return (new StoreEmployeeRequest)->messages();
    }

    public function updatedCanLogin($value)
    {
        if (! $value) {
            $this->email = '';
            $this->role = 'employee';
        }
    }

    public function save()
    {
        $this->validate();

        // Créer l'employé
        $employee = Employee::create([
            'company_id' => $this->tenant->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone_number' => $this->phone_number,
            'position' => $this->position,
            'department' => $this->department,
            'hire_date' => $this->hire_date,
            'active' => $this->active,
        ]);

        if ($this->can_login) {
            $user = User::create([
                // 'company_id' => $this->tenant->id, // TODO: delete this field to users table
                'email' => $this->email,
                'password' => Hash::make(Str::random(32)), // Mot de passe temporaire
            ]);

            $role = Role::where('name', $this->role)->first();

            if ($role) {
                $user->assignRole($role);
            }

            // Associer l'utilisateur à l'employé
            $employee->update(['user_id' => $user->id]);

            // Envoyer la notification d'invitation
            $this->sendInvitationNotification($user);
        }

        session()->flash('success', 'Employé créé avec succès.');

        return redirect()->route('dashboard.employees.index', [$this->tenant]);
    }

    private function sendInvitationNotification(User $user)
    {
        // Générer un token sécurisé pour 7 jours
        $setupUrl = URL::temporarySignedRoute(
            'dashboard.employee.setup-password',
            now()->addDays(7),
            ['tenant' => $this->tenant, 'user' => $user->id]
        );

        $user->notify(new EmployeeInvitation($this->tenant, $setupUrl));
    }

    public function render()
    {
        return view('livewire.dashboard.employee.create', [
            'roles' => Role::whereIn('name', ['employee', 'manager'])->get(),
        ])->extends('layouts.dashboard');
    }
}
