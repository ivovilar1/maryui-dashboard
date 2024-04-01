<?php

use App\Livewire\Customers;
use App\Models\{Customer, User};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
    $file = UploadedFile::fake()->image('avatar.jpg');
    Livewire::test(Customers\Create::class)
        ->set('form.name', 'Joe Doe')
        ->set('form.country', 'Brazil')
        ->set('form.avatar', $file)
        ->set('form.email', 'joe@doe.com')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSuccessful();

    /** @var Customer $customer */
    $customer = Customer::query()->latest()->first();
    assertDatabaseHas('customers', [
        'name'    => $customer->name,
        'country' => $customer->country,
        'avatar' => $customer->avatar,
        'email'   => $customer->email,
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

    test('avatar should be required', function () {
        Livewire::test(Customers\Create::class)
            ->set('form.avatar', '')
            ->call('save')
            ->assertHasErrors(['form.avatar' => __('validation.required', ['attribute' => 'avatar'])]);
    });
    test('avatar should a file ', function () {
        Livewire::test(Customers\Create::class)
            ->set('form.avatar', 'any content here')
            ->call('save')
            ->assertHasErrors(['form.avatar' => __('validation.file', ['attribute' => 'avatar'])]);
    });
    test('avatar should be a image', function () {
        $file = createFakeFile('avatar.csv', 100, 'text/csv');
        Livewire::test(Customers\Create::class)
            ->set('form.avatar', $file)
            ->call('save')
            ->assertHasErrors(['form.avatar' => __('validation.image', ['attribute' => 'avatar'])]);
    });
    test("avatar size shouldnt't be greater than 1mb", function () {
        $file = createFakeFile('avatar.jpg', 1500, 'image/jpg');
        Livewire::test(Customers\Create::class)
            ->set('form.avatar', $file)
            ->call('save')
            ->assertHasErrors(['form.avatar' => __('validation.max.file', ['attribute' => 'avatar', 'max' => '1024'])]);
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

function createFakeFile(string $name, int $size, string $mimeType): UploadedFile
{
    return UploadedFile::fake()->create($name, $size, $mimeType);
}
