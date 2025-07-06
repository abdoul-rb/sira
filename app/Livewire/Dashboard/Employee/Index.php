<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Employee;

use App\Models\Company;
use App\Models\Employee;
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

    public string $sortByLabel = 'Tri:';

    #[Url(as: 'field', history: true)]
    #[Locked]
    #[Validate('in:created_at,position,department,hire_date')]
    public string $sortField = 'created_at';

    #[Url(as: 'direction', history: true)]
    #[Locked]
    #[Validate('in:asc,desc')]
    public string $sortDirection = 'desc';

    public ?string $status = null;

    public $confirmingDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'status' => ['except' => null],
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

        $this->dispatch('sort-updated', field: $field, direction: $direction);
    }

    public function confirmDelete($employeeId)
    {
        $this->confirmingDelete = $employeeId;
    }

    public function deleteEmployee(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $employee->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Employé supprimé avec succès.');
    }

    public function render()
    {
        $query = Employee::where('company_id', $this->tenant->id)
            ->with(['user', 'company'])
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('firstname', 'like', "%{$this->search}%")
                        ->orWhere('lastname', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($q) {
                            $q->where('email', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->status, function ($q) {
                if ($this->status === 'connected') {
                    $q->whereNotNull('user_id');
                } elseif ($this->status === 'offline') {
                    $q->whereNull('user_id');
                }
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $employees = $query->paginate(10);

        return view('livewire.dashboard.employee.index', [
            'employees' => $employees,
        ])->extends('layouts.dashboard');
    }
}
