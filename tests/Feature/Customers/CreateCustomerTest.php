<?php

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Customers;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should render component', function () {

    Livewire::test(Customers\Create::class)->assertOk();

});

it('should be able to create customer', function () {

    Livewire::test(Customers\Create::class)
        ->set('form.name', 'Joe Doe')
        ->set('form.country', 'Brazil')
        ->set('form.avatar', 'https://i.pravatar.cc/150?img=1')
        ->set('form.email', 'joe@doe.com')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSuccessful();

    assertDatabaseHas('customers', [
        'name' => 'Joe Doe',
        'country' => 'Brazil',
        'avatar' => 'https://i.pravatar.cc/150?img=1',
        'email' => 'joe@doe.com',
    ]);
});
