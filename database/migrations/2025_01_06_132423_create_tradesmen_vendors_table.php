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
        Schema::create('tradesmen_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('category');
            $table->string('sub_category');
            $table->string('profile_picture')->nullable();
            $table->string('job_picture')->nullable();
            $table->text('description')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('guarantor_name');
            $table->string('guarantor_contact_number');
            $table->string('guarantor_id_image')->nullable();        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tradesmen_vendors');
    }
};
