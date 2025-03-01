<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MechanicalClearing;


class MechanicalClearingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['non_waterlogged', 'unstable_ground', 'swampy'];

        foreach ($categories as $category) {
            MechanicalClearing::firstOrCreate([
                'category' => $category
            ], [
                'area_of_land' => 1000,
                'preliminary_needed' => false,
                'no_of_days' => 10,
            ]);
        }
        
    }
}
