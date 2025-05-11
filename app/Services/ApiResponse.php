<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ApiResponse
 */
class ApiResponse
{
    /**
     * Handle a successful response.
     *
     * @param mixed $data
     *   The data to be returned in the response.
     * @param int $statusCode
     *   The HTTP status code for the response.
     * @param string|null $message
     *   An optional message to be included in the response.
     *
     * @return \Illuminate\Http\JsonResponse
     *   A JSON response with the specified data, status code, and message.
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
     *   An optional error message to be included in the response.
     * @param int $statusCode
     *   The HTTP status code for the error response.
     *
     * @return \Illuminate\Http\JsonResponse
     *   A JSON response with the specified error message and status code.
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
     *   An optional error message to be included in the response.
     * @param int $statusCode
     *   The HTTP status code for the unauthorized response.
     *
     * @return \Illuminate\Http\JsonResponse
     *   A JSON response with the specified error message and status code.
     */
    public static function unauthorized(string $message = null, int $statusCode = Response::HTTP_UNAUTHORIZED): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }
}
