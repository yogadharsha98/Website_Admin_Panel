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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // ← Add this

            // Product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('small_description')->nullable();
            $table->text('description')->nullable();

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();

            // Prices
            $table->decimal('original_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);

            // Quantity cache
            $table->integer('total_quantity')->default(0);

            $table->boolean(column: 'is_active')->default(1);
             $table->boolean('trending')->default(false);
             $table->boolean('featured')->default(false);
             $table->boolean('new_arrivals')->default(false);
             $table->boolean('on_sale')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};



