<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Customer;

use Livewire\Component;
use App\Enums\CustomerType;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Models\Company;
use App\Models\Customer;

class AddModal extends Component
{
    // TODO: rename to create with view
    public Company $tenant;
    
    public $type = 'lead';

    public $firstname = '';

    public $lastname = '';

    public $email = '';

    public $phone_number = '';

    public $address = '';

    protected function rules()
    {
        return (new StoreCustomerRequest)->rules();
    }

    protected function messages()
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

        Customer::create($validated);

        $this->reset(['type', 'firstname', 'lastname', 'email', 'phone_number', 'address']);

        $this->dispatch('close-modal', id: 'add-customer');
        $this->dispatch('customer-created');
    }

    public function render()
    {
        return view('livewire.dashboard.customer.add-modal', [
            'types' => CustomerType::cases(),
        ]);
    }
}
