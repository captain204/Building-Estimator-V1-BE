<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\Option;
use app\Models\SubOption;

class SubOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Option::factory()
        ->count(10) 
        ->has(SubOption::factory()->count(2)) 
        ->create();
    }
}
