<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Agent;

use App\Http\Requests\Agent\StoreAgentRequest;
use App\Models\Company;
use App\Models\Agent;
use Livewire\Component;

class AddModal extends Component
{
    public Company $tenant;

    public $title = null;

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

        return redirect()->route('dashboard.agents.index', ['tenant' => $this->tenant->slug]);
    }

    public function render()
    {
        return view('livewire.dashboard.agent.add-modal');
    }
}
