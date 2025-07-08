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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('social_id')->nullable(); // For social login, if applicable
            $table->string('avatar')->nullable(); // For profile picture
            $table->string('password')->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('location')->nullable(); // For main location
            $table->string('sub_location')->nullable(); // For sub-location
            $table->string('status')->default('Active')->nullable(); // Added 'status' column without 'after' clause
            $table->rememberToken(); // To remember user session
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
