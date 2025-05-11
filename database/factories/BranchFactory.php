<?php

namespace Database\Factories;

use App\Models\AdministrativeHierarchy;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'administrative_hierarchy_id' => AdministrativeHierarchy::factory(),
            'name' => $this->faker->company,
            'branch_code' => $this->faker->unique()->bothify('BRN-#####'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
