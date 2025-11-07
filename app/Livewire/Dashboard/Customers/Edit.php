<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Customers;

use App\Enums\CustomerType;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public Company $tenant;

    public Customer $customer;

    public $type;

    public string $firstname = '';

    public string $lastname = '';

    public string $email = '';

    public string $phoneNumber = '';

    public string $address = '';

    protected function rules(): array
    {
        return (new UpdateCustomerRequest)->rules();
    }

    protected function messages(): array
    {
        return (new UpdateCustomerRequest)->messages();
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    #[On('open-edit-customer-modal')]
    public function loadCurrentCustomer(int $customerId)
    {
        $this->customer = Customer::findOrFail($customerId);

        // $this->tenant = $tenant;

        $this->fill([
            'firstname' => $this->customer->firstname,
            'lastname' => $this->customer->lastname,
            'email' => $this->customer->email,
            'phoneNumber' => $this->customer->phone_number,
            'address' => $this->customer->address,
        ]);

        $this->dispatch('open-modal', id: 'edit-customer');
    }

    public function update()
    {
        // $this->authorize('create', Customer::class);
        $validated = $this->validate();
        $this->customer->update($validated);

        $this->reset();

        $this->dispatch('customer-updated');
        $this->dispatch('notify', 'Client mis à jour avec succès !');
        $this->dispatch('close-modal', id: 'edit-customer');
    }

    public function render()
    {
        return view('livewire.dashboard.customers.edit', [
            'types' => CustomerType::cases(),
        ]);
    }
}
