<?php

use App\Livewire\Customers;
use Livewire\Livewire;

it('should render a component', function () {
    Livewire::test(Customers\Index::class)->assertSuccessful();
});
