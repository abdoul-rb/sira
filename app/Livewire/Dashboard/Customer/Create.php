<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Customer;

use App\Enums\CustomerType;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use Livewire\Component;

class Create extends Component
{
    public Company $tenant;

    public $firstname = '';

    public $lastname = '';

    public $email = '';

    public $phone_number = '';

    public $type = 'lead';

    public $address = '';

    public $city = '';

    public $zip_code = '';

    public $country = '';

    protected function rules()
    {
        return (new StoreCustomerRequest)->rules();
    }

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function save()
    {
        $this->authorize('create', Customer::class);

        $validated = $this->validate();
        $validated['company_id'] = $this->tenant->id;

        Customer::create($validated);

        session()->flash('success', 'Client créé avec succès.');

        return redirect()->route('dashboard.customers.index', ['tenant' => $this->tenant->slug]);
    }

    public function render()
    {
        return view('livewire.dashboard.customer.create', [
            'types' => CustomerType::cases(),
        ])->extends('layouts.dashboard');
    }
}
