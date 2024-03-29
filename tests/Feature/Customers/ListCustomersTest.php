<?php

use App\Livewire\Customers;
use App\Models\Customer;
use App\Models\User;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
   $user = User::factory()->create();
   actingAs($user);
});
it('should be able to access the route customers', function () {
    get(route('customers'))
        ->assertOk();
});

it('should render a component', function () {
    Livewire::test(Customers\Index::class)->assertSuccessful();
});

it('should be able to list all customers', function () {
    $customers = Customer::factory()->count(10)->create();
    $lw = Livewire::test(Customers\Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)->toHaveCount(10);
        return true;
    });

    foreach ($customers as $customer) {
        $lw->assertSee($customer->name);
    }
});

test('check the table format', function () {
    Livewire::test(Customers\Index::class)->assertSet('headers', [
        ['key' => 'avatar', 'label' => '', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ['key' => 'country', 'label' => 'Country', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
    ]);
});

it('should be able to filter by name, country and email', function () {
    $joe   = Customer::factory()->create(['name' => 'Joe Doe', 'country' => 'Brazil', 'email' => 'admin@gmail.com']);
    $jiejie   = Customer::factory()->create(['name' => 'Jie Jie', 'country' => 'Malasia','email' => 'jiejie@gmail.com']);
    $mario = Customer::factory()->create(['name' => 'Mario', 'country' => 'Argentina', 'email' => 'little_guy@gmail.com']);

    Livewire::test(Customers\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)->toHaveCount(3);

            return true;
        })
        ->set('search', 'mar')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('Mario');

            return true;
        })
        ->set('search', 'guy')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('Mario');

            return true;
        })
        ->set('search', 'mal')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('Jie Jie');

            return true;
        });
});

it('should be able to sort by name', function () {
    $user  = User::factory()->create();
    $joe   = Customer::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $mario = Customer::factory()->create(['name' => 'Mario', 'email' => 'little_guy@gmail.com']);

    actingAs($user);
    Livewire::test(Customers\Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'name')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->name->toBe('Joe Doe')
                ->and($items)->last()->name->toBe('Mario');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->set('sortColumnBy', 'name')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->name->toBe('Mario')
                ->and($items)->last()->name->toBe('Joe Doe');

            return true;
        });
});
