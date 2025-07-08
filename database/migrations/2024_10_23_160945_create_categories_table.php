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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug')->unique(); // Unique slug for SEO
            $table->string('meta_title', 255)->nullable(); // Meta title for SEO
            $table->string('meta_keyword', 255)->nullable(); // Meta keywords for SEO
            $table->text('meta_description')->nullable(); // Meta description for SEO
            $table->string('image', 255)->nullable(); // Image path
            $table->boolean('is_active')->default(true); // Active status
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
