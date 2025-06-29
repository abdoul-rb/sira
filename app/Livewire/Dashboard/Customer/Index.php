<?php

namespace App\Livewire\Dashboard\Customer;

use App\Enums\CustomerType;
use App\Models\Company;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Company $tenant;

    public string $search = '';

    public string $sortField = 'lastname';

    public string $sortDirection = 'asc';

    public ?string $type = null;

    public $confirmingDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'lastname'],
        'sortDirection' => ['except' => 'asc'],
        'type' => ['except' => null],
        'page' => ['except' => 1],
    ];

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete($customerId)
    {
        $this->confirmingDelete = $customerId;
    }

    public function deleteCustomer(Customer $customer)
    {
        $customer->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Client supprimé avec succès.');
    }

    public function render()
    {
        $query = Customer::where('company_id', $this->tenant->id)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('firstname', 'like', '%' . $this->search . '%')
                        ->orWhere('lastname', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone_number', 'like', '%' . $this->search . '%')
                        ->orWhere('city', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->type, fn ($q) => $q->where('type', $this->type))
            ->orderBy($this->sortField, $this->sortDirection);

        $customers = $query->paginate(10);

        return view('livewire.dashboard.customer.index', [
            'customers' => $customers,
            'types' => CustomerType::cases(),
        ])->extends('layouts.dashboard');
    }
}
