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
        Schema::create('product_custom_field_values', function (Blueprint $table) {
            $table->id();
             // Foreign keys
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // This references the fields table, which stores the custom field definitions
            $table->foreignId('custom_field_id')->constrained('fields')->onDelete('cascade');

            // Store the value for the custom field on this product
            $table->text('value')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_custom_field_values');
    }
};
