<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\ApiResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();
            $token = $user->createToken('token')->plainTextToken;

            return ApiResponse::success([
                'token' => $token,
                'user' => $user,
            ], 200, 'Login successful');
        }

        return ApiResponse::unauthorized('Invalid credentials');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ApiResponse::success([], 200, 'Logout successful');
    }
}
