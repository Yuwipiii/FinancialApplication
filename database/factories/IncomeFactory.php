<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\IncomeCategory;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::first()->id,
            'wallet_id'=>Wallet::first()->id,
            'income_category_id'=>IncomeCategory::first()->id,
            'amount'=>$this->faker->numberBetween(1,10000),
            'date'=>$this->faker->date('Y-m-d'),
            'currency_id'=>Currency::first(),
            'note'=>$this->faker->words(4,3)
        ];
    }
}
