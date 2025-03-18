<?php

namespace App\Services\Action;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ActionResponse
{
    /**
     * Standard JSON response structure
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @param array|null $errors
     * @return JsonResponse
     */
    public static function success(?array $data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    /**
     * Error JSON response
     *
     * @param string $message
     * @param array|null $errors
     * @param int $status
     * @return JsonResponse
     */
    public static function error(string $message = 'Error', ?array $errors = null, int $status = 400): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }

    /**
     * Paginated Response
     *
     * @param LengthAwarePaginator $paginator
     * @param string $message
     * @return JsonResponse
     */
    public static function paginated(LengthAwarePaginator $paginator, string $message = 'Success'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ]
        ]);
    }
}
