<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class OnboardHome extends Component
{
    public function render()
    {
        return view('livewire.dashboard.onboard-home');
    }
}
