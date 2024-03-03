<?php

declare(strict_types=1);

namespace Common\Infrastructure\Response;

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
     *
     * @param mixed  $data    the data to be returned in the response
     * @param string $message the message to be included in the response
     * @param int    $status  the HTTP status code for the response
     * @param string $type    the type of the response
     * @param bool   $error   indicates whether the response is an error response
     */
    protected static function apiResponse(
        mixed $data,
        string $message,
        int $status,
        string $type,
        bool $error,
        array $headers
    ): JsonResponse {
        return new JsonResponse([
            'error' => $error,
            'type' => $type,
            'message' => $message,
            'data' => $data,
        ], $status, $headers);
    }
}
