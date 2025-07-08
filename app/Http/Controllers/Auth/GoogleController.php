<?php

namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function handleGoogleLogin(Request $request)
    {
        try {
            // Get user information from Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if customer exists, or create a new customer
            $customer = Customer::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'social_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]
            );

            // Create or retrieve an API token for the customer (Laravel Passport or Sanctum)
            $token = $customer->createToken('GoogleLoginToken')->plainTextToken;

            // Return the response with the token and user details
            return response()->json([
                'message' => 'Logged in successfully!',
                'token' => $token,
                'user' => $customer,
            ], 200);

        } catch (\Exception $e) {
            // Handle errors such as failed authentication
            return response()->json([
                'message' => 'Authentication failed.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
