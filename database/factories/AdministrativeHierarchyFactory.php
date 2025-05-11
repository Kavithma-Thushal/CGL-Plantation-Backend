<?php

namespace Database\Factories;

use App\Models\AdministrativeHierarchy;
use App\Models\AdministrativeLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdministrativeHierarchy>
 */
class AdministrativeHierarchyFactory extends Factory
{
    protected $model = AdministrativeHierarchy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'administrative_level_id' => AdministrativeLevel::factory(), // or AdministrativeLevel::inRandomOrder()->first()->id if you want to use existing levels
            'parent_id' => $this->faker->boolean(50) ? AdministrativeHierarchy::factory(['parent_id'=>null])->create()->id : null, // Ensure `parent_id` is a valid foreign key
            'name' => $this->faker->words(3, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
