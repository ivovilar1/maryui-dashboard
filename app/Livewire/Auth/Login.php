<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    public ?string $email = 'test@example.com';

    public ?string $password = 'password';

    public function render(): View
    {
        return view('livewire.auth.login');
    }

    public function login(): void
    {
        if (!Auth::attempt([
            'email'    => $this->email,
            'password' => $this->password,
        ])) {
            $this->addError('invalidCredentials', trans('These credentials do not match our records'));

            return;
        }

        $this->redirect(route('dashboard'));
    }
}
