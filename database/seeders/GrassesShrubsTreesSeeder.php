<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GrassesShrubsTrees;

class GrassesShrubsTreesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GrassesShrubsTrees::factory()->count(10)->create();

    }
}
