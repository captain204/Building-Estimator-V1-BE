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
        Schema::create('grasses_and_shrubs', function (Blueprint $table) {
            $table->id();
            $table->decimal('qty_area', 10, 2);
            $table->string('unit');
            $table->decimal('rate', 10, 2);
            $table->decimal('amount', 15, 2);
            $table->integer('no_of_days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grasses_and_shrubs');
    }
};
