<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Notifications\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmailRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.email-register'); // Ensure this points to the correct view
    }
    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email', // Unique validation for email
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            // Create a new customer
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Send the verification email
            $customer->notify(new EmailVerification($customer));

            // Redirect to a page informing the user to verify their email
            return redirect()->route('frontend.home')->with('success', 'Registration successful! Please check your email to verify your account.');

        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Registration failed! Please try again.')->withInput();
        }
    }

    public function verifyEmail($id, $hash)
    {
        // Find the customer by ID (assuming you have the ID in the verification link)
        $customer = Customer::find($id);

        // Check if the customer exists and the hash matches
        if ($customer) {
            if (hash_equals(sha1($customer->email), $hash)) {
                // Perform the email verification logic here
                $customer->email_verified_at = now();
                $customer->save();

                // Log the customer in after email verification
                Auth::guard('customer')->login($customer);

                return redirect()->route('frontend.home')->with('success', 'Your email has been verified successfully!');
            } else {
                // Hash mismatch
                return redirect()->route('frontend.home')->with('error', 'Email verification failed.');
            }
        }

        // Handle case where customer is not found
        return redirect()->route('frontend.home')->with('error', 'Customer not found.');
    }


}
