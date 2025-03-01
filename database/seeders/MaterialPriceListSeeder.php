<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\MaterialPriceList;

class MaterialPriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */
    public function run(): void
    {
        MaterialPriceList::factory(10)->create();
    }
}
