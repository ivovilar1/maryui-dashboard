<?php
use App\Livewire\Auth;
use App\Models\User;
use Livewire\Livewire;

it('should be able to render a login', function () {
    Livewire::test(Auth\Login::class)
        ->assertOk();
});

it('should be able to login', function () {
    $user = User::factory()->create([
        'email' => 'joe@doe.com',
        'password' => 'password'
    ]);

    Livewire::test(Auth\Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);
});
