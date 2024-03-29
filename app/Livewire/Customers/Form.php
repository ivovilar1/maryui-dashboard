<?php
namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Form as baseForm;


class Form extends baseForm
{
    public ?string $name = null;
    public ?string $country = null;
    public ?string $avatar = null;
    public ?string $email = null;

    public function create(): void
    {
        Customer::query()->create([
            'name' => $this->name,
            'country' => $this->country,
            'avatar' => $this->avatar,
            'email' => $this->email
        ]);
    }
}
