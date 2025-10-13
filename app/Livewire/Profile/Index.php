<?php

declare(strict_types=1);

namespace App\Livewire\Profile;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.profile.index')->extends('layouts.dashboard');
    }
}
