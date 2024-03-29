<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'   => 'Test User',
            'email'  => 'test@example.com',
            'avatar' => 'https://i.pravatar.cc/150?img=' . random_int(1, 50),
        ]);
        Customer::factory()->count(10)->create();
    }
}
