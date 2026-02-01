<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Members;

use App\Actions\Members\CreateMemberAction;
use App\Enums\RoleEnum;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Models\Company;
use App\Models\User;
use App\Notifications\MemberInvitation;
use App\Notifications\NewMemberAccountCreated;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public Company $company;

    public string $firstname = '';

    public string $lastname = '';

    public string $phoneNumber = '';

    public string $email = '';

    public string $password = '';

    public bool $canLogin = false;

    public ?RoleEnum $role = null;

    public function mount(Company $company)
    {
        $this->company = $company;
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
        $validated['company_id'] = $this->company->id;

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
            ['company' => $this->company, 'user' => $user->id]
        );

        $user->notify(new MemberInvitation($this->company, $setupUrl));
    }

    public function render()
    {
        return view('livewire.dashboard.members.create');
    }
}
