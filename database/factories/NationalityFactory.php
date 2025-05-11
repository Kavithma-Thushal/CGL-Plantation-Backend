<?php

namespace Database\Factories;

use App\Models\Nationality;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nationality>
 */
class NationalityFactory extends Factory
{
    protected $model = Nationality::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_by' => User::factory(),
            'name' => $this->faker->country, // Generate a fake nationality name
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
