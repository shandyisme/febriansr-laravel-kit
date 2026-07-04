<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

/**
 * Standardised JSON envelope for API responses.
 *
 * Every payload follows the shape:
 *   { "success": bool, "message": string, "data": mixed, ... }
 *
 * Keeping this in one place guarantees a consistent contract across the whole
 * API surface (see AGENTS.md → "Response API konsisten").
 */
final class ApiResponse
{
    /**
     * A successful response.
     *
     * @param  mixed  $data  The payload to return (array, model, resource, scalar or null).
     * @param  string  $message  Human-readable status message.
     * @param  int  $code  HTTP status code (defaults to 200 OK).
     */
    public static function success(mixed $data = null, string $message = 'OK', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * An error response.
     *
     * @param  string  $message  Human-readable error message.
     * @param  int  $code  HTTP status code (defaults to 400 Bad Request).
     * @param  array<string, mixed>|null  $errors  Optional field-level validation errors.
     */
    public static function error(string $message, int $code = 400, ?array $errors = null): JsonResponse
    {
        $payload = [
            'success' => false,
            'message' => $message,
            'data' => null,
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $code);
    }

    /**
     * A paginated collection response.
     *
     * The items are placed under `data` while pagination metadata is exposed
     * under a dedicated `meta` key so clients can build pagers reliably.
     *
     * @param  LengthAwarePaginator<int, mixed>  $paginator
     */
    public static function paginated(LengthAwarePaginator $paginator, string $message = 'OK'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ], 200);
    }
}
