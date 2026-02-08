<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Members;

use App\Actions\Members\CreateMemberAction;
use App\Enums\RoleEnum;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Livewire\Traits\ManagesPhoneNumbers;
use App\Models\Company;
use App\Models\User;
use App\Services\InvitationService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    use ManagesPhoneNumbers;

    public Company $tenant;

    public string $firstname = '';

    public string $lastname = '';

    public string $phoneNumber = '';

    public string $email = '';

    public string $password = '';

    public bool $canLogin = false;

    public ?RoleEnum $role = null;

    public string $countryCode = 'CI';

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

        // Format phone number to E.164
        $validated['phoneNumber'] = $this->formatToE164($validated['phoneNumber'], $validated['countryCode']);
        unset($validated['countryCode']); // Ne pas sauvegarder le code pays séparément

        try {
            $member = $action->handle($validated);

            if ($member->user) {
                $this->sendInvitationNotification($member->user);
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

    private function sendInvitationNotification(User $user): void
    {
        app(InvitationService::class)->sendInvitation($user, $this->tenant);
    }

    public function render()
    {
        return view('livewire.dashboard.members.create');
    }
}
