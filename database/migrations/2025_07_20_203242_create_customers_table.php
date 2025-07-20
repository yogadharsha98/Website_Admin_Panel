<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password')->nullable(); // nullable for OAuth users
            $table->string('provider')->nullable(); // e.g. google, facebook
            $table->string('provider_id')->nullable(); // OAuth provider user id
            // Address fields, nullable initially
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('district')->nullable();
            $table->string('town')->nullable();
            $table->string('status')->default('active'); // Add status field
            $table->rememberToken();
            $table->timestamps();
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
