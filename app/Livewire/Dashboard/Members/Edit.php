<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Members;

use App\Http\Requests\Member\UpdateMemberRequest;
use App\Models\Company;
use App\Models\Member;
use App\Models\User;
use App\Notifications\MemberInvitation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public Company $tenant;

    public Member $member;

    public string $firstname = '';

    public string $lastname = '';

    public string $phoneNumber = '';

    public bool $canLogin = false;

    // Champs utilisateur (conditionnels)
    public $email = '';

    public $role = 'member';

    public function mount(Company $tenant, Member $member)
    {
        $this->tenant = $tenant;
        $this->member = $member;

        $this->fill([
            'firstname' => $member->firstname,
            'lastname' => $member->lastname,
            'phoneNumber' => $member->phoneNumber,
        ]);

        if ($member->user) {
            $this->canLogin = true;
            $this->email = $member->user->email;
        }
    }

    protected function rules(): array
    {
        return (new UpdateMemberRequest)->rules();
    }

    protected function messages(): array
    {
        return (new UpdateMemberRequest)->messages();
    }

    /* public function updatedCanLogin($value)
    {
        if (! $value) {
            $this->email = '';
            $this->role = 'member';
        }
    } */

    public function update()
    {
        // Validation de base
        $this->validate();

        // Validation conditionnelle pour l'email si l'employé peut se connecter
        if ($this->canLogin) {
            // Vérifier l'unicité de l'email en tenant compte de l'utilisateur existant
            $existingEmail = User::where('email', $this->email)
                ->when($this->member->user, function ($query) {
                    $query->where('id', '!=', $this->member->user->id);
                })
                ->exists();

            if ($existingEmail) {
                $this->addError('email', 'Cet email est déjà utilisé par un autre utilisateur.');
                return;
            }
        }

        // Mettre à jour l'employé
        $this->member->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phoneNumber' => $this->phoneNumber,
        ]);

        // Gérer l'utilisateur
        if ($this->canLogin) {
            if ($this->member->user) {
                // Mettre à jour l'utilisateur existant
                $this->member->user->update([
                    'email' => $this->email,
                ]);

                // Mettre à jour le rôle
                $role = Role::where('name', $this->role)->first();
                
                if ($role) {
                    $this->member->user->syncRoles([$role]);
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
                $this->member->update(['user_id' => $user->id]);

                // Envoyer la notification d'invitation
                $this->sendInvitationNotification($user);
            }
        } else {
            // Supprimer l'association utilisateur si elle existe
            if ($this->member->user) {
                $this->member->update(['user_id' => null]);
                // Note: On ne supprime pas l'utilisateur pour éviter la perte de données
            }
        }

        session()->flash('success', 'Employé modifié avec succès.');
        return redirect()->route('dashboard.members.index', [$this->tenant]);
    }

    private function sendInvitationNotification(User $user)
    {
        // Générer un token sécurisé pour 7 jours
        $setupUrl = URL::temporarySignedRoute(
            'dashboard.member.setup-password',
            now()->addDays(7),
            ['user' => $user->id]
        );

        // Envoyer la notification d'invitation
        $user->notify(new MemberInvitation($this->tenant, $setupUrl));
    }

    public function render()
    {
        return view('livewire.dashboard.members.edit');
    }
}
