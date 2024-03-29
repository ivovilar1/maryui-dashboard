<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->name,
            'country' => $this->faker->country,
            'avatar' => 'https://i.pravatar.cc/150?img=' . random_int(1, 50),
            'email' => $this->faker->unique()->safeEmail
        ];
    }
}
