<?php

namespace Database\Seeders;

use App\Models\UpcomeCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpcomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UpcomeCategory::factory(3)->create();
    }
}
