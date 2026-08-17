<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        // Ensure password is hashed for compatibility
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        Auth::login($user);

        return response()->json(['user' => $user], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $request->session()->regenerate();

        return response()->json(['user' => Auth::user()]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([], 204);
    }

    public function user(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return response()->json(['user' => $user]);
    }
}
