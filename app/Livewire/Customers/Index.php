<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Support\Table\Header;
use App\Traits\Livewire\HasTable;
use Livewire\WithPagination;

class Index extends Component
{
    use HasTable;
    use WithPagination;

    public function render(): View
    {
        return view('livewire.customers.index');
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('avatar', ''),
            Header::make('name', 'Name'),
            Header::make('country', 'Country'),
            Header::make('email', 'Email'),
        ];
    }

    public function query(): Builder
    {
        return Customer::query();
    }

    public function searchColumns(): array
    {
        return [
            'name',
            'country',
            'email'
        ];
    }
}
