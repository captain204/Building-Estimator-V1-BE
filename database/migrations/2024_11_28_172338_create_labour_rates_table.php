<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('labour_rates', function (Blueprint $table) {
            $table->id();
            $table->string('area_of_work');
            $table->string('lower_point_daily_rate_per_day');
            $table->string('higher_point_daily_rate_per_day');
            $table->string('average_point_daily_rate_per_day');
            $table->string('unit_of_costing');
            $table->string('lower_point_daily_rate_per_unit');
            $table->string('higher_point_daily_rate_per_unit');
            $table->string('average_point_daily_rate_per_unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labour_rates');
    }
};
