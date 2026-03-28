<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:wedder,visitor',
        ]);

        // Create user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return response
        return response()->json([
            'message'    => 'User registered successfully',
            'data'       => $user,
            'token'      => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request){
        //validate 
        $validate = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        //find user
        $user = User::where('email', $validate['email'])->first();

        if(!$user || !Hash::check($validate['password'], $user->password)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        //delete old token 
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Login successful',
            'data' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer'
        ], 200);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    public function me(Request $request){
        $data = $request->user();
        return response()->json([
            'data' => $data
        ]);
    }
}