<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Purchase;

use App\Enums\CustomerType;
use App\Models\Company;
use App\Models\Customer;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Purchase;

class Index extends Component
{
    use WithPagination;

    public Company $tenant;

    #[Url]
    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function render()
    {
        $query = Purchase::where('company_id', $this->tenant->id)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('details', 'like', "%{$this->search}%");
                });
            });

        $purchases = $query->paginate(10);

        return view('livewire.dashboard.purchase.index', [
            'purchases' => $purchases,
            'totalAmount' => $purchases->sum('amount'),
            'averageAmount' => $purchases->avg('amount'),
        ])->extends('layouts.dashboard');
    }
}
