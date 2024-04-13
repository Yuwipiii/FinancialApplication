<?php

namespace Database\Seeders;

 use App\Models\User;
 use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory([
            'name' => 'Eldos Ulanbekov',
            'email' => 'test@example.com',
        ])->create();
        Currency::factory()->create(['base' => 'USD', 'counter' => 'KGS', 'mid' => '89.33']);
        Currency::factory()->create(['base' => 'KGS', 'counter' => 'USD', 'mid' => '0.011']);
        $this->call([WalletSeeder::class]);
    }
}
