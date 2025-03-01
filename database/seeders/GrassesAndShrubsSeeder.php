<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GrassesAndShrubs;


class GrassesAndShrubsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GrassesAndShrubs::factory()->count(10)->create();

    }
}
