<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Customers;

use App\Enums\CustomerType;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Livewire\Traits\ManagesPhoneNumbers;
use App\Models\Company;
use App\Models\Customer;
use Livewire\Component;

class Create extends Component
{
    use ManagesPhoneNumbers;

    public Company $tenant;

    public $type = 'lead';

    public string $firstname = '';

    public string $lastname = '';

    public string $email = '';

    public string $phone_number = '';

    public string $address = '';

    public string $countryCode = 'CI';

    protected function rules(): array
    {
        return (new StoreCustomerRequest)->rules();
    }

    protected function messages(): array
    {
        return (new StoreCustomerRequest)->messages();
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function save()
    {
        // $this->authorize('create', Customer::class);
        $validated = $this->validate();
        $validated['company_id'] = $this->tenant->id;

        // TODO: externaliser
        $validated['phone_number'] = $this->formatToE164($validated['phone_number'], $validated['countryCode']);
        unset($validated['countryCode']); // Ne pas sauvegarder le code pays séparément

        Customer::create($validated);

        $this->reset(['type', 'firstname', 'lastname', 'email', 'phone_number', 'address']);

        $this->dispatch('close-modal', id: 'add-customer');
        $this->dispatch('customer-created');
    }

    public function render()
    {
        return view('livewire.dashboard.customers.create', [
            'types' => CustomerType::cases(),
        ]);
    }
}
