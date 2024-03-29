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
