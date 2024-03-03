<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'base'=>$this->faker->word,
            'counter'=>$this->faker->word,
            'mid'=>$this->faker->randomFloat(0.1,100.0),
            'time'=>$this->faker->date('Y-m-d')
        ];
    }
}
