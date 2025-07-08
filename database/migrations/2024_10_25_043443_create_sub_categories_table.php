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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('category_id');
            $table->string('title'); // Title of the sub-category
            $table->string('slug')->unique(); // Unique slug for the sub-category
            $table->boolean('is_active')->default(true); // Status of the sub-category
            $table->timestamps(); // Created at and updated at timestamps
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_categories'); // Drop the table if it exists
    }
};
