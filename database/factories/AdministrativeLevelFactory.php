<?php

namespace Database\Factories;

use App\Models\AdministrativeLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdministrativeLevel>
 */
class AdministrativeLevelFactory extends Factory
{
    protected $model = AdministrativeLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => $this->faker->boolean(50) ? AdministrativeLevel::factory(['parent_id'=>null])->create()->id : null, // Ensure `parent_id` is a valid foreign key
            'name' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
