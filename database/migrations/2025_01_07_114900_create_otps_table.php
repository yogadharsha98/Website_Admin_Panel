<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id(); // Primary key (auto increment)
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Foreign key referencing the 'customers' table
            $table->string('phone_number'); // Phone number
            $table->string('otp'); // OTP value
            $table->boolean('is_verified')->default(false); // Verification status (false by default)
            $table->softDeletes(); // Soft delete column (deleted_at)
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
}
