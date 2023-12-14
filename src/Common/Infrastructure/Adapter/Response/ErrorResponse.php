<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ErrorResponse
 * This class extends the ApiResponse class and is used to create error responses.
 * It provides a constructor to format the data to be returned in the response.
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ErrorResponse extends ApiResponse
{
    const string DEFAULT_TYPE = 'error';
    const string DEFAULT_MESSAGE = 'error_message';
    const int HTTP_INTERNAL_SERVER_ERROR = 500;

    /**
     * Get the JSON response for an error.
     * @param mixed|null $data The data to be returned in the response.
     * @param int $status The HTTP status code for the response. Defaults to HTTP_INTERNAL_SERVER_ERROR.
     * @param string $message The message to be included in the response. Defaults to DEFAULT_MESSAGE.
     * @param string $type
     * @param array $headers
     * @return JsonResponse
     */
    public static function response(
        mixed  $data = null,
        int    $status = self::HTTP_INTERNAL_SERVER_ERROR,
        string $message = self::DEFAULT_MESSAGE,
        string $type = self::DEFAULT_TYPE,
        array  $headers = []
    ): JsonResponse
    {
        return self::apiResponse($data, $status, $message, $type, true, $headers);
    }
}
