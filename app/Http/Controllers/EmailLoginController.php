<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.email-login'); // Ensure this points to the correct view
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        // Attempt to log the customer in using the 'customer' guard
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed, redirect to intended route with success message
            return redirect()->route('frontend.home')->with('success', 'Login successful!');
        }

        // Authentication failed, redirect back with error message
        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->with('error', 'Login failed! Please check your credentials.');
    }

}
