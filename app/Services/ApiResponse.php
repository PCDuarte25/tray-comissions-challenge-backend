<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Handle a successful response.
     *
     * @param array $data
     * @param int $statusCode
     * @param string|null $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(array $data = [], int $statusCode = 200, string $message = null): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Handle an error response.
     *
     * @param string|null $message
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(string $message = null, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Handle a unauthorized error response.
     *
     * @param string|null $message
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function unauthorized(string $message = null, int $statusCode = 401): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }
}
