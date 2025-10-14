<?php

declare(strict_types=1);

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Company;

class Index extends Component
{
    public Company $tenant;
    
    public function mount(Company $tenant)
    {
        $this->tenant = $tenant;
    }

    public function render()
    {
        return view('livewire.profile.index')->extends('layouts.dashboard');
    }
}
