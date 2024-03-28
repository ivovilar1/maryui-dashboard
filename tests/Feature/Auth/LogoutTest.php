<?php

use App\Livewire\Auth;
use Livewire\Livewire;

it('should be able to render logout component', function () {

    Livewire::test(Auth\Logout::class)->assertStatus(200);

});
