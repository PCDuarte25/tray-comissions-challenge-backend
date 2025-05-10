<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\ApiResponse;
use Illuminate\Http\Response;

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
            ], Response::HTTP_OK, 'Login successful');
        }

        return ApiResponse::unauthorized('Invalid credentials');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ApiResponse::success([], Response::HTTP_OK, 'Logout successful');
    }
}
