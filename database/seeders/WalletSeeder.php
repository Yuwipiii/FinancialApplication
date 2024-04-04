<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wallet::factory(['name'=>"Mbank",'balance'=>20000])->count(1)->create();
    }
}
