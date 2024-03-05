<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Eldos Ulanbekov',
            'email' => 'test@example.com',
        ]);
        Currency::factory()->create(['base' => 'USD', 'counter' => 'KGS', 'mid' => '89.33']);
        Currency::factory()->create(['base' => 'KGS', 'counter' => 'USD', 'mid' => '0.011']);
        $this->call([WalletSeeder::class, CategorySeeder::class, ExpenseSeeder::class]);
        IncomeCategory::factory(2)->create();
        Income::factory(4)->create();
    }
}
