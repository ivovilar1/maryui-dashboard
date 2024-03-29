<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.customers.index');
    }

    #[Computed]
    public function customers(): Collection
    {
        return Customer::query()->get();
    }
}
