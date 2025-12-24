<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\UserAccount;

class AuthController extends Controller
{
    // POST /auth/register
     public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|string',
        ]);

        $user = UserAccount::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['user' => $user], 201);
    }

    // POST /auth/login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Find user by email
        $user = UserAccount::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate token using HasApiTokens trait
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // POST /auth/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    // POST /auth/forgot-password
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = UserAccount::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $token = Str::random(60);
        // Store $token in password_resets table and send email

        return response()->json(['message' => 'Password reset token sent']);
    }

    // POST /auth/reset-password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        // Verify token in password_resets
        // Update password and delete token

        return response()->json(['message' => 'Password reset successfully']);
    }
}
