<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiResponse
 * This abstract class extends the JsonResponse class from Symfony and is used to create API responses.
 * It provides a constructor to format the data to be returned in the response.
 */
abstract class ApiResponse
{
    /**
     * Get the JSON response.
     * @param mixed $data The data to be returned in the response.
     * @param int $status The HTTP status code for the response.
     * @param string $message The message to be included in the response.
     * @param string $type The type of the response.
     * @param bool $error Indicates whether the response is an error response.
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected static function apiResponse(
        mixed  $data,
        int    $status,
        string $message,
        string $type,
        bool   $error,
        array  $headers
    ): JsonResponse
    {
        return new JsonResponse([
            'error' => $error,
            'type' => $type,
            'message' => $message,
            'data' => $data,
        ], $status, $headers);
    }
}