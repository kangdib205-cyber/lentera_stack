<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Core\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'business_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Create business
        $businessName = $request->business_name ?: $request->name . ' Business';
        $business = Business::create([
            'name' => $businessName,
            'slug' => Str::slug($businessName) . '-' . Str::random(5),
            'timezone' => 'Asia/Jakarta',
            'currency' => 'IDR',
            'is_active' => true,
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'business_id' => $business->id,
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        // Log the user in
        Auth::login($user);

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user->load('business'),
        ], 201);
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $user->update([
            'last_login_at' => now(),
        ]);

        return response()->json([
            'message' => 'Login successful',
            'user' => $user->load('business'),
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Get the authenticated user.
     */
    public function user(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user' => $user ? $user->load('business') : null,
        ]);
    }
}
