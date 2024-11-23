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
        Schema::create('sub_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade'); 
            $table->string('name');  
            $table->enum('type', ['dropdown', 'checkbox', 'form'])->default('dropdown')->nullable(); 
            $table->text('description')->nullable();
            $table->text('question')->nullable();
            $table->boolean('is_required')->default(false); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_options');
    }
};
