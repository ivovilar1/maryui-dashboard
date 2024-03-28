<?php

use App\Livewire\Auth;
use App\Models\User;
use Livewire\Livewire;

it('should be able to render logout component', function () {

    Livewire::test(Auth\Logout::class)->assertStatus(200);

});

it('should be able to can logout our system', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Auth\Logout::class)
        ->call('logout')
        ->assertOk()
        ->assertRedirect(route('login'));

    expect(auth())->guest()->toBeTrue();
});
