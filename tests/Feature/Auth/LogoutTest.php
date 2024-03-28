<?php

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Auth;

it('should be able to render logout component', function () {

    Livewire::test(Auth\Logout::class)->assertStatus(200);

});
