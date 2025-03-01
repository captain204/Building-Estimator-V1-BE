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
        Schema::create('mechanical_clearings', function (Blueprint $table) {
            $table->id();
            $table->integer('area_of_land');
            $table->string('preliminary_needed');
            $table->integer('no_of_days');
            $table->enum('category', ['non_waterlogged', 'unstable_ground', 'swampy'])->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanical_clearings');
    }
};
