<?php

namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $customer = Customer::firstOrCreate(
                ['email' => $facebookUser->getEmail()],
                [
                    'name' => $facebookUser->getName(),
                    'social_id' => $facebookUser->getId(), // You can use a separate field for Facebook ID if necessary
                    'avatar' => $facebookUser->getAvatar(),
                ]
            );

            // Log the customer in
            Auth::login($customer);

            // Redirect to the home page
            return redirect()->route('frontend.home'); // Make sure this route exists

        } catch (\Exception $e) {
            return redirect()->route('customer-sign-in.index')->withErrors(['msg' => 'Authentication failed.']);
        }
    }
}
