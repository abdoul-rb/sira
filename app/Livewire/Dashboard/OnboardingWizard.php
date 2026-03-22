<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use App\Actions\Dashboard\CompleteOnboardingAction;
use App\Http\Requests\Dashboard\OnboardingFormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class OnboardingWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;

    public string $companyName = '';

    public string $country = 'CI';

    public ?UploadedFile $companyLogo = null;

    public string $shopName = '';

    public string $shopDescription = '';

    public function getCountriesProperty(): array
    {
        return config('countries');
    }

    public function mount()
    {
        $this->restoreFromCache();
    }

    protected function rules(): array
    {
        return (new OnboardingFormRequest)->rules();
    }

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'companyName' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'companyLogo' => 'nullable|image|max:2048',
            ]);

            $this->shopName = $this->companyName;
        } elseif ($this->step === 2) {
            $this->validate([
                'shopName' => 'required|string|max:255',
                'shopDescription' => 'nullable|string',
            ]);
        }

        $this->step++;
        $this->saveToCache();
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
            $this->saveToCache();
        }
    }

    public function submit(CompleteOnboardingAction $action)
    {
        $validated = $this->validate();

        $company = $action->handle(auth()->user(), $validated, $this->companyLogo);

        $this->clearCache();

        return redirect()->intended(route('dashboard.index', ['tenant' => $company]));
    }

    private function getCacheKey(): string
    {
        return 'onboarding:' . auth()->id();
    }

    private function saveToCache()
    {
        Cache::put($this->getCacheKey(), [
            'step' => $this->step,
            'companyName' => $this->companyName,
            'country' => $this->country,
            'shopName' => $this->shopName,
            'shopDescription' => $this->shopDescription,
        ], now()->addHour());
    }

    private function restoreFromCache()
    {
        $cache = Cache::get($this->getCacheKey());

        if ($cache) {
            $this->step = $cache['step'] ?? 1;
            $this->companyName = $cache['companyName'] ?? '';
            $this->country = $cache['country'] ?? '';
            $this->shopName = $cache['shopName'] ?? '';
            $this->shopDescription = $cache['shopDescription'] ?? '';
        }
    }

    private function clearCache()
    {
        Cache::forget($this->getCacheKey());
    }

    public function render()
    {
        return view('livewire.dashboard.onboarding-wizard');
    }
}
