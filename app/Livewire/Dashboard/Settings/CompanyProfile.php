<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Settings;

use App\Actions\Profile\UpdateCompanyAction;
use App\Http\Requests\Profile\UpdateCompanyRequest;
use App\Livewire\Traits\ManagesPhoneNumbers;
use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanyProfile extends Component
{
    use WithFileUploads;
    use ManagesPhoneNumbers;

    public Company $tenant;

    public ?string $name = '';

    public ?UploadedFile $logo = null;

    public ?string $currentLogoPath = null;

    public ?string $description = '';

    public ?string $phoneNumber = '';

    public ?string $websiteUrl = '';

    public ?string $address = '';

    public string $countryCode = 'CI';

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;

        // Extract country code from existing phone number
        $this->countryCode = $this->extractCountryCodeFromPhone($this->tenant->phone_number);

        $this->fill([
            'name' => $this->tenant->name,
            'description' => $this->tenant->description,
            'phoneNumber' => $this->extractLocalNumber($this->tenant->phone_number, $this->countryCode),
            'websiteUrl' => $this->tenant->website,
            'address' => $this->tenant->address,
        ]);

        $this->currentLogoPath = $this->tenant->logo_path ? Storage::disk('public')->url($this->tenant->logo_path) : null;

    }

    protected function rules(): array
    {
        return (new UpdateCompanyRequest)->rules();
    }

    protected function messages(): array
    {
        return (new UpdateCompanyRequest)->messages();
    }

    public function updatedWebsiteUrl()
    {
        if ($this->websiteUrl && ! str_starts_with($this->websiteUrl, 'http://')) {
            $this->websiteUrl = 'https://' . $this->websiteUrl;
        }
    }

    public function removeTempLogo()
    {
        $this->logo = null;
    }

    public function removeCurrentLogo()
    {
        if ($this->currentLogoPath) {
            Storage::disk('public')->delete($this->currentLogoPath);

            $this->currentLogoPath = null;

            // On efface aussi en base si tu veux immédiatement
            $this->tenant->update(['logo' => null]);
        }
    }

    public function update(UpdateCompanyAction $action)
    {
        $validated = $this->validate();

        // Format phone number to E.164
        $validated['phoneNumber'] = $this->formatToE164($validated['phoneNumber'], $validated['countryCode']);
        unset($validated['countryCode']); // Ne pas sauvegarder le code pays séparément

        $action->handle($this->tenant, $validated);

        $this->dispatch('notify', 'Informations mis à jour !');
    }


    public function render()
    {
        return view('livewire.dashboard.settings.company-profile');
    }
}
