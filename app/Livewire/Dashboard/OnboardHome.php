<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Component;

class OnboardHome extends Component
{
    public function render()
    {
        return view('livewire.dashboard.onboard-home')
            ->extends('layouts.base')
            ->section('body');
    }
}
