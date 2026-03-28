<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use App\Actions\Dashboard\RegisterAndOnboardAction;
use App\Http\Requests\Dashboard\RegisterOnboardingFormRequest;
use App\Livewire\Traits\ManagesPhoneNumbers;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Livewire\Component;

class RegisterOnboardingWizard extends Component
{
    use ManagesPhoneNumbers;

    public int $step = 1;

    // --- Step 1 : Compte utilisateur ---
    public string $name = '';

    public string $countryCode = 'CI';

    public string $phoneNumber = '';

    public string $password = '';

    public string $companyName = '';

    public function mount(): void
    {
        $this->restoreFromCache();
        $this->deconstructPhoneNumber();
    }

    protected function rules(): array
    {
        return (new RegisterOnboardingFormRequest)->rules();
    }

    protected function messages(): array
    {
        return (new RegisterOnboardingFormRequest)->messages();
    }

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $originalPhoneNumber = $this->phoneNumber;

            if (! empty($this->phoneNumber)) {
                $this->phoneNumber = $this->formatToE164($this->phoneNumber, $this->countryCode);
            }

            try {
                $this->validate($this->step1Rules());
            } catch (\Illuminate\Validation\ValidationException $e) {
                $this->phoneNumber = $originalPhoneNumber;
                throw $e;
            }
        } elseif ($this->step === 2) {
            $this->validate($this->step2Rules());
        }

        $this->step++;
        $this->saveToCache();
    }

    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
            $this->saveToCache();
            $this->deconstructPhoneNumber();
        }
    }

    public function submit(RegisterAndOnboardAction $action): mixed
    {
        $validated = $this->validate();

        try {
            ['user' => $user, 'company' => $company] = $action->handle($validated);

            event(new Registered($user));

            Auth::login($user, true);

            $this->clearCache();

            return redirect()->route('dashboard.index', ['tenant' => $company]);
        } catch (Exception $e) {
            Log::error('RegisterAndOnboard failed', ['error' => $e->getMessage()]);
            $this->addError('companyName', __('Une erreur est survenue. Veuillez reessayer.'));
        }

        return null;
    }

    private function step1Rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phoneNumber' => ['required', 'string', 'unique:users,phone_number', 'max:26'],
            'password' => ['required', Password::min(6)/* ->mixedCase() */],
        ];
    }

    private function step2Rules(): array
    {
        return [
            'companyName' => 'required|string|max:255',
        ];
    }

    private function getCacheKey(): string
    {
        return 'onboarding:' . session()->getId();
    }

    private function saveToCache(): void
    {
        Cache::put($this->getCacheKey(), [
            'step' => $this->step,
            'name' => $this->name,
            'countryCode' => $this->countryCode,
            'phoneNumber' => $this->phoneNumber,
            'companyName' => $this->companyName,
        ], now()->addHour());
    }

    private function restoreFromCache(): void
    {
        $cache = Cache::get($this->getCacheKey());

        if ($cache) {
            $this->step = $cache['step'] ?? 1;
            $this->name = $cache['name'] ?? '';
            $this->countryCode = $cache['countryCode'] ?? 'CI';
            $this->phoneNumber = $cache['phoneNumber'] ?? '';
            $this->companyName = $cache['companyName'] ?? '';
        }
    }

    private function clearCache(): void
    {
        Cache::forget($this->getCacheKey());
    }

    private function deconstructPhoneNumber(): void
    {
        if ($this->step === 1 && str_starts_with($this->phoneNumber, '+')) {
            $this->countryCode = $this->extractCountryCodeFromPhone($this->phoneNumber);
            $local = $this->extractLocalNumber($this->phoneNumber, $this->countryCode);
            // On enlève les espaces pour l'affichage dans l'input
            $this->phoneNumber = str_replace(' ', '', $local);
        }
    }

    public function render(): View
    {
        return view('livewire.dashboard.register-onboarding-wizard');
    }
}
