<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CallRequest;

class CallbackRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CallRequest::factory(10)->create();
    }
}
