<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Logout extends Component
{
    public function render(): View
    {
        return view('livewire.auth.logout');
    }
}
