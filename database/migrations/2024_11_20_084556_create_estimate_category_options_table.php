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
        Schema::create('estimate_category_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('estimate_categories')->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['dropdown', 'checkbox', 'form'])->default('dropdown')->nullable();
            $table->json('options')->nullable(); 
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_category_options');
    }
};
