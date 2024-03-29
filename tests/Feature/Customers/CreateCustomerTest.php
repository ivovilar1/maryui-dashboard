<?php

use Livewire\Livewire;
use App\Livewire\Customers;

it('should render component', function () {

    Livewire::test(Customers\Create::class)->assertOk();

});
