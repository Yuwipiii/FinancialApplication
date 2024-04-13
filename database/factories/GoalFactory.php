<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>1,
            'name'=>$this->faker->word(),
            'target_amount'=>$this->faker->numberBetween(1,1000),
            'current_amount'=>$this->faker->numberBetween(1,999),
            'is_completed'=>$this->faker->numberBetween(0,1),
        ];
    }
}
