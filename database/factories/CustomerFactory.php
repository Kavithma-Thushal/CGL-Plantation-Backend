<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // or User::inRandomOrder()->first()->id if you want to use existing users
            'customer_number' => $this->faker->unique()->numerify('CUS-#####'),
            'licence_number' => $this->faker->optional()->bothify('LIC-#####'),
            'passport_number' => $this->faker->optional()->bothify('PAS-#####'),
            'status' => $this->faker->boolean ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
