<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Agent;

use App\Http\Requests\Agent\StoreAgentRequest;
use App\Models\Agent;
use App\Models\Company;
use Livewire\Component;

class AddModal extends Component
{
    public Company $tenant;

    public $firstname = '';

    public $lastname = '';

    public $phone_number = '';

    public $localization = '';

    protected function rules()
    {
        return (new StoreAgentRequest)->rules();
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

        Agent::create($validated);

        session()->flash('success', 'Agent créé avec succès.');

        $this->dispatch('close-modal', id: 'add-agent');
        $this->dispatch('agent-created');
    }

    public function render()
    {
        return view('livewire.dashboard.agent.add-modal');
    }
}
