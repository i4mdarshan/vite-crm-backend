<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class APIResponseHelper
{
    /**
     * Send a standardized JSON response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @param bool $success
     * @param array $pagination
     * @param array $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendResponse(
        $data = null, 
        string $message = '', 
        int $status = 200, 
        bool $success = true, 
        array $pagination = [], 
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => $success,
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'pagination' => $pagination,
            'meta' => array_merge([
                'timestamp' => now(),
                'request_id' => request()->header('X-Request-ID', uniqid()),
            ], $meta),
            'links' => [],
        ];

        return response()->json($response, $status);
    }

    /**
     * Send an error response.
     *
     * @param string $message
     * @param int $status
     * @param mixed $errors
     * @param array $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendError(
        string $message, 
        int $status = 400, 
        $errors = null, 
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => false,
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
            'meta' => array_merge([
                'timestamp' => now(),
                'request_id' => request()->header('X-Request-ID', uniqid()),
            ], $meta),
        ];

        return response()->json($response, $status);
    }

    /**
     * Send a paginated response with additional links.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @param bool $success
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @param array $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendPaginatedResponse(
        $data, 
        string $message = '', 
        int $status = 200, 
        bool $success = true, 
        $paginator, 
        array $meta = []
    ): JsonResponse {
        $pagination = [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
        ];

        $links = [
            'self' => $paginator->url($paginator->currentPage()),
            'first' => $paginator->url(1),
            'last' => $paginator->url($paginator->lastPage()),
            'next' => $paginator->nextPageUrl(),
            'prev' => $paginator->previousPageUrl(),
        ];

        $response = [
            'success' => $success,
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'pagination' => $pagination,
            'meta' => array_merge([
                'timestamp' => now(),
                'request_id' => request()->header('X-Request-ID', uniqid()),
            ], $meta),
            'links' => $links,
        ];

        return response()->json($response, $status);
    }
}
