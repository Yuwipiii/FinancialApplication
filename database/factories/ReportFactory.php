<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date'=>$this->faker->dateTimeThisYear->format('Y-m'),
            'user_id'=>User::first(),
            'category_id'=> Category::where('user_id',User::first()->id)->inRandomOrder()->first(),
            'currency'=>$this->faker->randomElement(Wallet::CURRENCIES),
            'total_amount'=>$this->faker->randomFloat(2,1,10000)
        ];
    }
}
