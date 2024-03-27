<?php
use App\Livewire\Auth;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => 'password',
    ]);
});

it('should be able to render a login', function () {
    Livewire::test(Auth\Login::class)
        ->assertOk();
});

it('should be able to login', function () {

    Livewire::test(Auth\Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($this->user->id);
});
it('should make sure to inform to the user an error when email and password not working', function () {

    Livewire::test(Auth\Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'passw')
        ->call('login')
        ->assertHasErrors(['invalidCredentials'])
        ->assertSee(trans('These credentials do not match our records'));
});
