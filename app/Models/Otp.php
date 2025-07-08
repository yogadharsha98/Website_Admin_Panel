<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Otp extends Model
{
    use HasFactory;
    use SoftDeletes; // Use soft deletes if you want to implement soft delete functionality

    protected $table = 'otps';

    // Fillable attributes
    protected $fillable = [
        'customer_id', // Ensure this is filled to link OTP to the customer
        'phone_number',
        'otp',
        'is_verified',
    ];

    // Timestamps
    public $timestamps = true; // Enables created_at and updated_at fields

    // Casts
    protected $casts = [
        'is_verified' => 'boolean', // Cast is_verified to a boolean
        'created_at' => 'datetime', // Ensure created_at is treated as a DateTime instance
        'updated_at' => 'datetime', // Ensure updated_at is treated as a DateTime instance
    ];

    // Define the relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class); // Assuming you have a Customer model
    }


}
