<?php

namespace Database\Factories;

use App\Enum\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

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
        $image = $this->faker->image(null, 360, 360, 'animals', true, true, 'cats', true);
        $imageFile = new File($image);

        return [
            'name'    => $this->faker->name,
            'country' => $this->faker->randomElement(Country::cases())->value,
            'avatar'  => Storage::disk('public')->putFile('images', $imageFile),
            'email'   => $this->faker->unique()->safeEmail,
        ];
    }
}
