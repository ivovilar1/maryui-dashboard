<?php

use App\Livewire\Customers;
use App\Models\{Customer, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

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
        'name'    => 'Joe Doe',
        'country' => 'Brazil',
        'avatar'  => 'https://i.pravatar.cc/150?img=1',
        'email'   => 'joe@doe.com',
    ]);
});

describe('validations', function () {

    test('name', function ($rule, $value) {
        Livewire::test(Customers\Create::class)
            ->set('form.name', $value)
            ->call('save')
            ->assertHasErrors(['form.name' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'Jo'],
        'max'      => ['max', str_repeat('J', 46)],
    ]);

    test('country', function ($rule, $value) {
        Livewire::test(Customers\Create::class)
            ->set('form.country', $value)
            ->call('save')
            ->assertHasErrors(['form.country' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'BBB'],
        'max'      => ['max', str_repeat('B', 46)],
    ]);

    test('avatar', function ($rule, $value) {
        Livewire::test(Customers\Create::class)
            ->set('form.avatar', $value)
            ->call('save')
            ->assertHasErrors(['form.avatar' => $rule]);
    })->with([
        'required' => ['required', ''],
        'max'      => ['max', str_repeat('B', 256)],
    ]);
    test('avatar should be url', function () {
        Livewire::test(Customers\Create::class)
            ->set('form.avatar', 'not-url')
            ->call('save')
            ->assertHasErrors(['form.avatar' => 'url']);
    });

    test('email', function ($rule, $value) {
        Livewire::test(Customers\Create::class)
            ->set('form.email', $value)
            ->call('save')
            ->assertHasErrors(['form.email' => $rule]);
    })->with([
        'required' => ['required', ''],
        'max'      => ['max', str_repeat('B', 66)],
    ]);

    test('email should be valid', function () {
        Livewire::test(Customers\Create::class)
            ->set('form.email', 'not-valid-email')
            ->call('save')
            ->assertHasErrors(['form.email' => 'email']);
    });

    test('email should be unique', function () {
        Customer::factory()->create(['email' => 'joe@doe.com']);
        Livewire::test(Customers\Create::class)
            ->set('form.email', 'joe@doe.com')
            ->call('save')
            ->assertHasErrors(['form.email' => 'unique']);
    });
});
