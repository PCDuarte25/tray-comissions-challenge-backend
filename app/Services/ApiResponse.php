<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse
{
    /**
     * Handle a successful response.
     *
     * @param mixed $data
     * @param int $statusCode
     * @param string|null $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(mixed $data = [], int $statusCode = Response::HTTP_OK, string $message = null): JsonResponse
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
    public static function error(string $message = null, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
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
    public static function unauthorized(string $message = null, int $statusCode = Response::HTTP_UNAUTHORIZED): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }
}
