<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'SuperAdmin1',
            'email' => 'buildingestimatorsuper1@admin.com', 
            'role' => 1,
            'password' => bcrypt('PassmeNow') 
        ]);
        
        User::factory()->create([
            'name' => 'SuperAdmin2',
            'email' => 'buildingestimator2@admin.com', 
            'role' => 1,
            'password' => bcrypt('BuildAdmin') 
        ]);*/
        /*$this->call(EstimateCategorySeeder::class);
        $this->call(EstimateCategoryOptionSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(SubOptionSeeder::class)*/;
        #$this->call(LabourRatesSeeder::class);
        #$this->call(CallbackRequestSeeder::class);
        #$this->call(EventSeeder::class);
        #$this->call(MaterialPriceList::class);
        //$this->call(ProfileSeeder::class);
        //$this->call(BlogSeeder::class);
        #$this->call(CostTrackerSeeder::class);
        #$this->call([EstimatorSeeder::class,]);
        $this->call([TradesmenVendorSeeder::class,]);


    }
}
