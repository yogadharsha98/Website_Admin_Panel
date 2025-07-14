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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Website Info
            $table->string('website_name')->nullable();
            $table->string('image')->nullable();
            $table->string('website_url')->nullable();
            $table->string('page_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();

            // Website Information
            $table->text('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('google_map_url')->nullable();

            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();

            // Social Media
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();

            // Footer
            $table->text('add_info')->nullable();
            $table->string('copy_right_txt')->nullable();
            $table->date('copyright_date')->nullable();
            $table->text('footer_url')->nullable();

            // Footer Images
            $table->string('footer_img_1')->nullable();
            $table->string('footer_img_2')->nullable();
            $table->string('footer_img_3')->nullable();
            $table->string('footer_img_4')->nullable();
            $table->string('footer_img_5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
