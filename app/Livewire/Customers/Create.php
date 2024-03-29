<?php

namespace App\Livewire\Customers;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public Form $form ;
    public function render(): View
    {
        return view('livewire.customers.create');
    }

    public function save():void
    {
        $this->form->create();
    }
}
