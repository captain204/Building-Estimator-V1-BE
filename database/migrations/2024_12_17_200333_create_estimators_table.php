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
        Schema::create('estimators', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable()->default(NULL);
            $table->enum('type', ['custom', 'automated']);
            $table->longText('work_items')->nullable();
            $table->longText('specifications')->nullable();
            $table->json('to_array')->nullable(); // JSON column
            $table->longText('variable')->nullable();
            $table->longText('to_html')->nullable();
            $table->string('require_custom_building')->nullable();
            $table->longText('other_information')->nullable();
            $table->boolean('is_urgent')->default(1);
            $table->boolean('agree')->default(0);
            $table->boolean('custom_more')->default(0);
            $table->longText('classes')->nullable();
            $table->timestamps();
    
            // Foreign key relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimators');
    }
};
