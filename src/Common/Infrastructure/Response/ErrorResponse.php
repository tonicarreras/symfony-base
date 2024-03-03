<?php

declare(strict_types=1);

namespace Common\Infrastructure\Response;

use Common\Domain\Exception\Constant\ExceptionStatusCode;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ErrorResponse
 * This class extends the ApiResponse class and is used to create error responses.
 * It provides a constructor to format the data to be returned in the response.
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ErrorResponse extends ApiResponse
{
    public const string DEFAULT_TYPE = 'error';
    public const string DEFAULT_MESSAGE = 'error_message';

    /**
     * Get the JSON response for an error.
     *
     * @param mixed|null $data    the data to be returned in the response
     * @param int        $status  The HTTP status code for the response. Defaults to HTTP_INTERNAL_SERVER_ERROR.
     * @param string     $message The message to be included in the response. Defaults to DEFAULT_MESSAGE.
     */
    public static function response(
        mixed $data = null,
        int $status = ExceptionStatusCode::INTERNAL_ERROR,
        string $message = self::DEFAULT_MESSAGE,
        string $type = self::DEFAULT_TYPE,
        array $headers = []
    ): JsonResponse {
        return self::apiResponse($data, $message, $status, $type, true, $headers);
    }
}
