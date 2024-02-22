<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wallet_id'=> $this->faker->randomElement(Wallet::all()),
            'user_id'=>User::first(),
            'category_id'=> $this->faker->randomElement( User::first()->category),
            'amount'=>$this->faker->randomFloat(2,1,100),
            'date'=> $this->faker->dateTimeBetween('now','+1 month'),
            'currency'=>$this->faker->randomElement(Wallet::CURRENCIES)
        ];
    }
}
