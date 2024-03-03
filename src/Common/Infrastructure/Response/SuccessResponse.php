<?php

declare(strict_types=1);

namespace Common\Infrastructure\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SuccessResponse
 * This class extends the ApiResponse class and is used to create success responses.
 * It provides methods to create a standard get response and a standard create response.
 */
final class SuccessResponse extends ApiResponse
{
    public const string DEFAULT_TYPE = 'success';
    public const string DEFAULT_MESSAGE = 'success_message';
    public const int HTTP_OK = 200;
    public const int HTTP_CREATED = 201;

    /**
     * Create a standard success response for created resources.
     *
     * @param mixed  $data    The data to be returned in the response
     * @param string $message The message to be included in the response
     * @param int    $status  The HTTP status code for the response
     * @param string $type    The type of the response
     * @param array  $headers Any additional headers to be added to the response
     *
     * @return JsonResponse The success response
     */
    public static function create(mixed $data = null, string $message = self::DEFAULT_MESSAGE, int $status = self::HTTP_CREATED, string $type = self::DEFAULT_TYPE, array $headers = []): JsonResponse
    {
        return self::apiResponse($data, $message, $status, $type, false, $headers);
    }

    /**
     * Get a standard success response.
     *
     * @param mixed  $data    The data to be returned in the response
     * @param string $message The message to be included in the response
     * @param int    $status  The HTTP status code for the response
     * @param string $type    The type of the response
     * @param array  $headers Any additional headers to be added to the response
     *
     * @return JsonResponse The success response
     */
    public static function get(mixed $data = null, string $message = self::DEFAULT_MESSAGE, int $status = self::HTTP_OK, string $type = self::DEFAULT_TYPE, array $headers = []): JsonResponse
    {
        return self::apiResponse($data, $message, $status, $type, false, $headers);
    }
}
