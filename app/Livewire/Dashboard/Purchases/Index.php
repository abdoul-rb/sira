<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Purchases;

use App\Models\Company;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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

    /**
     * Ouvre le forumulaire modal d'edition
     *
     * @return void
     */
    public function edit(int $purchaseId)
    {
        $this->dispatch('open-edit-purchase-modal', purchaseId: $purchaseId);
    }

    public function render()
    {
        $query = Purchase::where('company_id', $this->tenant->id)
            ->when($this->search, function (Builder $q) {
                $q->where(function (Builder $q) {
                    $q->where('details', 'like', "%{$this->search}%");
                });
            });

        $purchases = $query->paginate(10);

        return view('livewire.dashboard.purchases.index', [
            'purchases' => $purchases,
            'totalAmount' => $purchases->sum('amount'),
            'averageAmount' => $purchases->avg('amount') ?? 0,
        ])->extends('dashboard.settings.index')
            ->section('viewbody');
    }
}
