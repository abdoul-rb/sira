<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Employee;

use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\EmployeeInvitation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public Company $tenant;

    public Employee $employee;

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

    public function mount(Company $tenant, Employee $employee)
    {
        $this->tenant = $tenant;
        $this->employee = $employee;

        $this->fill([
            'firstname' => $employee->firstname,
            'lastname' => $employee->lastname,
            'phone_number' => $employee->phone_number,
            'position' => $employee->position,
            'department' => $employee->department,
            'hire_date' => $employee->hire_date?->format('Y-m-d'),
            'active' => $employee->active,
        ]);

        if ($employee->user) {
            $this->can_login = true;
            $this->email = $employee->user->email;
            $this->role = $employee->user->roles->first()?->name ?? 'employee';
        }
    }

    protected function rules(): array
    {
        return (new UpdateEmployeeRequest)->rules();
    }

    protected function messages(): array
    {
        return (new UpdateEmployeeRequest)->messages();
    }

    /* public function updatedCanLogin($value)
    {
        if (! $value) {
            $this->email = '';
            $this->role = 'employee';
        }
    } */

    public function update()
    {
        // Validation de base
        $this->validate();

        // Validation conditionnelle pour l'email si l'employé peut se connecter
        if ($this->can_login) {
            // Vérifier l'unicité de l'email en tenant compte de l'utilisateur existant
            $existingEmail = User::where('email', $this->email)
                ->when($this->employee->user, function ($query) {
                    $query->where('id', '!=', $this->employee->user->id);
                })
                ->exists();

            if ($existingEmail) {
                $this->addError('email', 'Cet email est déjà utilisé par un autre utilisateur.');
                return;
            }
        }

        // Mettre à jour l'employé
        $this->employee->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone_number' => $this->phone_number,
            'position' => $this->position,
            'department' => $this->department,
            'hire_date' => $this->hire_date,
            'active' => $this->active,
        ]);

        // Gérer l'utilisateur
        if ($this->can_login) {
            if ($this->employee->user) {
                // Mettre à jour l'utilisateur existant
                $this->employee->user->update([
                    'email' => $this->email,
                ]);

                // Mettre à jour le rôle
                $role = Role::where('name', $this->role)->first();
                
                if ($role) {
                    $this->employee->user->syncRoles([$role]);
                }
            } else {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'company_id' => $this->tenant->id,
                    'email' => $this->email,
                    'password' => Hash::make(Str::random(32)),
                ]);

                // Assigner le rôle
                $role = Role::where('name', $this->role)->first();
                
                if ($role) {
                    $user->assignRole($role);
                }

                // Associer l'utilisateur à l'employé
                $this->employee->update(['user_id' => $user->id]);

                // Envoyer la notification d'invitation
                $this->sendInvitationNotification($user);
            }
        } else {
            // Supprimer l'association utilisateur si elle existe
            if ($this->employee->user) {
                $this->employee->update(['user_id' => null]);
                // Note: On ne supprime pas l'utilisateur pour éviter la perte de données
            }
        }

        session()->flash('success', 'Employé modifié avec succès.');
        return redirect()->route('dashboard.employees.index', [$this->tenant]);
    }

    private function sendInvitationNotification(User $user)
    {
        // Générer un token sécurisé pour 7 jours
        $setupUrl = URL::temporarySignedRoute(
            'dashboard.employee.setup-password',
            now()->addDays(7),
            ['user' => $user->id]
        );

        // Envoyer la notification d'invitation
        $user->notify(new EmployeeInvitation($this->tenant, $setupUrl));
    }

    public function render()
    {
        return view('livewire.dashboard.employee.edit', [
            'roles' => Role::whereIn('name', ['employee', 'manager'])->get(),
        ])->extends('layouts.dashboard');
    }
}
