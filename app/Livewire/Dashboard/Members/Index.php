<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Members;

use App\Models\Company;
use App\Models\Member;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithPagination;

    public Company $tenant;

    #[Url]
    public string $search = '';

    public string $sortByLabel = 'Tri:';

    #[Url(as: 'field', history: true)]
    #[Locked]
    #[Validate('in:created_at')]
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

    // TODO: remove
    public function confirmDelete($memberId)
    {
        $this->confirmingDelete = $memberId;
    }

    public function delete(Member $member)
    {
        $this->authorize('delete', $member);

        $member->delete();

    // TODO: remove
        $this->confirmingDelete = null;
        session()->flash('success', 'Member supprimé avec succès.');
    }

    public function render()
    {
        $query = Member::where('company_id', $this->tenant->id)
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
            ->orderBy($this->sortField, $this->sortDirection);

        $members = $query->paginate(10);

        return view('livewire.dashboard.members.index', [
            'members' => $members,
        ]);
    }
}
