<?php

namespace Database\Factories;

use App\Enum\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\{Http, Storage};
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'    => $this->faker->name,
            'country' => $this->faker->randomElement(Country::cases())->value,
            'avatar'  => $this->faker->image,
            'email'   => $this->faker->unique()->safeEmail,
        ];
    }
}
