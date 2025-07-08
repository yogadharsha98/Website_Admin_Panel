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
    Schema::create('category_fields', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->bigInteger('category_id')->unsigned(); // Foreign key for category
        $table->bigInteger('sub_category_id')->unsigned()->nullable(); // Foreign key for subcategory
        $table->bigInteger('field_id')->unsigned(); // Foreign key for field
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
        $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_fields');
    }
};
