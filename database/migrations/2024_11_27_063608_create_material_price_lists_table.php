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
        Schema::create('material_price_lists', function (Blueprint $table) {
            $table->id();
            $table->string('price_group');
            $table->string('material');
            $table->string('specification');
            $table->string('size');
            $table->integer('low_price_point');
            $table->integer('higher_price_point');
            $table->integer('average_price_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_price_lists');
    }
};
