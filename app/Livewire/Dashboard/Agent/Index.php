<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Agent;

use App\Models\Agent;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Company $tenant;

    #[Url]
    public string $search = '';

    #[Url(as: 'field', history: true)]
    #[Locked]
    public string $sortField = 'lastname';

    #[Url(as: 'direction', history: true)]
    #[Locked]
    #[Validate('in:asc,desc')]
    public string $sortDirection = 'desc';

    public ?string $type = null;

    public $confirmingDelete = null;

    public $selectedCustomer = null;

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

    public function sortBy(string $field, string $direction = 'desc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;

        // Dispatch l'événement avec les valeurs des propriétés
        $this->dispatch('sort-updated', field: $field, direction: $direction);
    }

    public function confirmDelete($customerId)
    {
        $this->confirmingDelete = $customerId;
    }

    public function deleteCustomer(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Client supprimé avec succès.');
    }

    public function showCustomerOrders(Customer $customer)
    {
        $this->selectedCustomer = $customer;
        logger()->info('Client sélectionné pour les commandes', ['customer_id' => $customer->id, 'customer_name' => $customer->fullname]);
    }

    public function render()
    {
        $query = Agent::where('company_id', $this->tenant->id)
            ->when($this->search, function (Builder $q) {
                $q->where(function (Builder $q) {
                    $q->where('firstname', 'like', "%{$this->search}%")
                        ->orWhere('lastname', 'like', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $agents = $query->paginate(10);

        return view('livewire.dashboard.agent.index', [
            'agents' => $agents,
        ])->extends('layouts.dashboard');
    }
}
