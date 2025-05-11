<?php

namespace Database\Factories;

use App\Models\Designation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Designation>
 */
class DesignationFactory extends Factory
{
    protected $model = Designation::class;

    public function definition()
    {
        return [
            'parent_id' => $this->faker->boolean(50) ? Designation::factory(['parent_id'=>null])->create()->id : null, // Ensure `parent_id` is a valid foreign key
            'name' => $this->faker->word(),
            'orc' => $this->faker->numberBetween(0, 100), // Ensure `orc` is between 0 and 100
            'code' => $this->faker->word(),
        ];
    }
}
