<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> User::first(),
            'name'=>$this->faker->word,
            'type'=> $this->faker->randomElement(Wallet::TYPES),
            'balance'=>$this->faker->randomFloat(2,1,1000000)
        ];
    }
}
