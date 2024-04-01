<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Form as baseForm;

class Form extends baseForm
{
    public ?string $name = '';

    public ?string $country = '';

    public $avatar;

    public ?string $email = '';

    public function rules(): array
    {
        return [
            'name'    => ['required', 'min:3', 'max:45'],
            'country' => ['required', 'min:4', 'max:45'],
            'avatar'  => ['required', 'file', 'image', 'max:1024', 'mimes:jpg,png,jpeg'],
            'email'   => ['required', 'max:65', 'email', 'unique:customers'],
        ];
    }

    public function create(): void
    {
        $this->validate();

        Customer::query()->create([
            'name'    => $this->name,
            'country' => $this->country,
            'avatar'  => $this->avatar->store('avatars'),
            'email'   => $this->email,
        ]);
    }
}
