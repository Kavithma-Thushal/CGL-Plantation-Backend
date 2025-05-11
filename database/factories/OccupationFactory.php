<?php

namespace Database\Factories;

use App\Models\Occupation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Occupation>
 */
class OccupationFactory extends Factory
{
    protected $model = Occupation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_by' => User::factory(),
            'name' => $this->faker->jobTitle, // Generate a fake occupation name
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
