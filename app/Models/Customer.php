<?php

namespace App\Models;

use App\Models\Otp;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken as SanctumToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable; // Import the Authenticatable interface

class Customer extends Model implements Authenticatable // Implement the Authenticatable interface
{
    use HasFactory, Notifiable, AuthenticatableTrait;
    use HasApiTokens;

    protected $table = 'customers'; // Specify the table name

    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'email',
        'social_id',
        'avatar',
        'password',
        'phone_number',
        'location',
        'sub_location',
        'status'
    ];

    // Hidden attributes that should not be visible in arrays or JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the OTPs for the customer.
     */
    public function otps()
    {
        return $this->hasMany(Otp::class); // A customer can have multiple OTPs
    }

    public function tokens()
    {
        return $this->hasMany(SanctumToken::class, 'tokenable_id'); // Linking the tokenable_id to the customer
    }

}
