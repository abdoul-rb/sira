<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Members;

use App\Http\Requests\Member\StoreMemberRequest;
use App\Models\Company;
use App\Models\Member;
use App\Models\User;
use App\Notifications\MemberInvitation;
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

    public $phoneNumber = '';

    public $canLogin = false;

    // Champs utilisateur (conditionnels)
    public $email = '';

    public $password = '';

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    protected function rules(): array
    {
        return (new StoreMemberRequest)->rules();
    }

    protected function messages(): array
    {
        return (new StoreMemberRequest)->messages();
    }

    public function updatedCanLogin($value)
    {
        if (! $value) {
            $this->email = '';
        }
    }

    public function save()
    {
        $this->validate();

        $member = Member::create([
            'company_id' => $this->tenant->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phoneNumber' => $this->phoneNumber
        ]);

        if ($this->canLogin) {
            $user = User::create([
                // 'company_id' => $this->tenant->id, // TODO: delete this field to users table
                'email' => $this->email,
                'password' => Hash::make($this->password), // Mot de passe temporaire : Str::random(32)
            ]);

            $role = Role::where('name', $this->role)->first();

            if ($role) {
                $user->assignRole($role);
            }

            // Associer l'utilisateur à l'employé
            $member->update(['user_id' => $user->id]);

            // Envoyer la notification d'invitation
            $this->sendInvitationNotification($user);
        }

        session()->flash('success', 'Membre créé avec succès.');

        return redirect()->route('dashboard.members.index', [$this->tenant]);
    }

    private function sendInvitationNotification(User $user)
    {
        // Générer un token sécurisé pour 7 jours
        $setupUrl = URL::temporarySignedRoute(
            'dashboard.members.setup-password',
            now()->addDays(7),
            ['tenant' => $this->tenant, 'user' => $user->id]
        );

        $user->notify(new MemberInvitation($this->tenant, $setupUrl));
    }

    public function render()
    {
        return view('livewire.dashboard.members.create');
    }
}
