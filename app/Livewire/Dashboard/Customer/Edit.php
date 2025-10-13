<?php

namespace App\Livewire\Dashboard\Customer;

use App\Enums\CustomerType;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use Livewire\Component;

class Edit extends Component
{
    public Company $tenant;

    public Customer $customer;

    public $firstname;

    public $lastname;

    public $email;

    public $phone_number;

    public $type;

    public $address;

    public $city;

    public $zip_code;

    public $country;

    protected function rules()
    {
        return (new UpdateCustomerRequest)->rules();
    }

    public function mount(Company $tenant, Customer $customer)
    {
        $this->authorize('view', $customer);

        $this->tenant = $tenant;
        $this->customer = $customer;
        $this->firstname = $customer->firstname;
        $this->lastname = $customer->lastname;
        $this->email = $customer->email;
        $this->phone_number = $customer->phone_number;
        $this->type = $customer->type->value;
        $this->address = $customer->address;
        $this->city = $customer->city;
        $this->zip_code = $customer->zip_code;
        $this->country = $customer->country;
    }

    public function save()
    {
        $this->authorize('update', $this->customer);
        $validated = $this->validate();
        $this->customer->update($validated);

        session()->flash('success', 'Client modifié avec succès.');

        return to_route('dashboard.customers.edit', [$this->tenant, $this->customer]);
    }

    public function render()
    {
        return view('livewire.dashboard.customer.edit', [
            'types' => CustomerType::cases(),
        ])->extends('layouts.dashboard');
    }
}
