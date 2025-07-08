<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse | JsonResponse// Adjust return type to include both
    {
        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            // Get the authenticated user
            $user = Auth::user();

            // Check if the request expects a JSON response
            if ($request->wantsJson()) {
                // Return a response with the user and a token (if using Sanctum)
                return response()->json(['user' => $user, 'token' => $user->createToken('LoginToken')->plainTextToken]);
            }

            // Add a success message to the session
            session()->flash('success', 'Logged in successfully!');


            // Redirect to the home page for web requests
            return redirect()->route('home'); // Ensure 'home' route is defined in your routes/web.php
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log out the user
        Auth::guard('web')->logout();

        // Revoke the user's tokens if they are logged out from the API
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // Invalidate and regenerate the session token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page (auth.login route)
        return redirect()->route('auth.login'); // This should point to the login page
    }

}
