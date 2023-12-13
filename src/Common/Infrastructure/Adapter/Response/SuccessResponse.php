<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Response;

/**
 * Class SuccessResponse
 * This class extends the ApiResponse class and is used to create success responses.
 * It provides methods to create a standard get response and a standard create response.
 */
final class SuccessResponse extends ApiResponse
{
    public const string DEFAULT_TYPE = 'success';
    public const string DEFAULT_MESSAGE = 'success_message';

    /**
     * SuccessResponse constructor.
     * @param mixed|null $data The data to be returned in the response.
     * @param int $status The HTTP status code for the response.
     * @param string $message The message to be included in the response.
     * @param string $type The type of the response.
     */
    public function __construct(
        $data = null,
        int $status = self::HTTP_OK,
        string $message = self::DEFAULT_MESSAGE,
        string $type = self::DEFAULT_TYPE
    )
    {
        parent::__construct($data, $status, $message, $type, false);
    }

    /**
     * Creates a standard get response.
     *
     * @param mixed|null $data    The data to be returned in the response.
     * @param string     $message The message to be included in the response.
     * @return self Returns an instance of the SuccessResponse class.
     */
    public static function get(mixed $data = null, string $message = self::DEFAULT_MESSAGE): self
    {
        return new self($data, self::HTTP_OK, $message, self::DEFAULT_TYPE, false);
    }

    /**
     * Creates a standard create response.
     *
     * @param mixed|null $data    The data to be returned in the response.
     * @param string     $message The message to be included in the response.
     * @return self Returns an instance of the SuccessResponse class.
     */
    public static function create(mixed $data = null, string $message = 'created'): self
    {
        return new self($data, self::HTTP_CREATED, $message, self::DEFAULT_TYPE, false);
    }
}
