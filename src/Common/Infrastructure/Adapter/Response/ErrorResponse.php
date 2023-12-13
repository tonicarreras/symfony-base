<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Response;

/**
 * Class ErrorResponse
 * This class extends the ApiResponse class and is used to create error responses.
 * It provides a constructor to format the data to be returned in the response.
 */
final class ErrorResponse extends ApiResponse
{
    public const string DEFAULT_TYPE = 'error';
    public const string DEFAULT_MESSAGE = 'error_message';

    /**
     * ErrorResponse constructor.
     * @param mixed|null $data The data to be returned in the response.
     * @param int $status The HTTP status code for the response. Defaults to HTTP_INTERNAL_SERVER_ERROR.
     * @param string $message The message to be included in the response. Defaults to DEFAULT_MESSAGE.
     * @param string $type The type of the response. Defaults to DEFAULT_TYPE.
     */
    public function __construct(
        $data = null,
        int $status = self::HTTP_INTERNAL_SERVER_ERROR,
        string $message = self::DEFAULT_MESSAGE,
        string $type = self::DEFAULT_TYPE
    )
    {
        parent::__construct($data, $status, $message, $type, true);
    }
}