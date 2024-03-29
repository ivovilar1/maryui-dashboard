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
    $lw->assertSet('customers', function ($items) {
        expect($items)->toHaveCount(10);
        return true;
    });

    foreach ($customers as $customer) {
        $lw->assertSee($customer->name);
    }
});
