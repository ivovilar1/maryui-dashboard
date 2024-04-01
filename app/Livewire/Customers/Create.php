<?php

namespace App\Livewire\Customers;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public Form $form;
    public function render(): View
    {
        return view('livewire.customers.create');
    }

    public function save(): void
    {
        $this->form->create();
    }
}
