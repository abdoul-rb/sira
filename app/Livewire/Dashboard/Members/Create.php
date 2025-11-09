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
use App\Actions\Members\CreateMemberAction;
use App\Enums\RoleEnum;
use App\Notifications\NewMemberAccountCreated;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Exception;
use Illuminate\Support\Facades\Log;

class Create extends Component
{
    public Company $tenant;

    public string $firstname = '';

    public string $lastname = '';

    public string $phoneNumber = '';

    public string $email = '';

    public string $password = '';

    public bool $canLogin = false;

    public ?RoleEnum $role = null;

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

    public function updatedCanLogin()
    {
        $temporaryPassword = Str::random(10);
        $this->password = $temporaryPassword;
    }

    public function save(CreateMemberAction $action)
    {
        $validated = $this->validate();
        $validated['company_id'] = $this->tenant->id;

        try {
            $member = $action->handle($validated);

            if ($member->user) {
                $member->user->notify(new NewMemberAccountCreated($this->password));
            }

            $this->dispatch('close-modal', id: 'create-member');
            $this->dispatch('notify', 'Employé ajouté avec succès !');
            $this->dispatch('member-created');
        } catch (Exception $e) {
            Log::error('Create member failed', [
                'email' => $validated['email'],
                'error' => $e->getMessage(),
            ]);

            $this->addError('email', __("Erreur lors de la création de l'utilisateur"));
        }
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
