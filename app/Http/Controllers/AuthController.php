<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\ApiResponse;
use Illuminate\Http\Response;

/**
 * Controller for handling authentication.
 */
class AuthController extends Controller
{
    /**
     * Login a user.
     *
     * @param \App\Http\Requests\LoginRequest $request
     *   The login request.
     *
     * @return \App\Services\ApiResponse
     *   The response containing the token and user information.
     */
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

    /**
     * Logout the authenticated user.
     *
     * @return \App\Services\ApiResponse
     *   The response indicating logout success.
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ApiResponse::success([], Response::HTTP_OK, 'Logout successful');
    }
}
