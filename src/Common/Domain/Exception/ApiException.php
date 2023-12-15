<?php

declare(strict_types=1);

namespace Common\Domain\Exception;

use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\Constant\ExceptionType;

/**
 * ApiException class to represent API-specific exceptions.
 *
 * This class extends the base Exception class, adding a 'type' property
 * to categorize the nature of the exception. It is specifically tailored
 * for API error handling, allowing for a consistent structure across
 * API-related error management.
 */
class ApiException extends \Exception
{
    /**
     * @var string a string indicating the type of the exception
     */
    protected string $type;

    /**
     * Constructor for the ApiException class.
     *
     * Initializes a new instance of the ApiException with a status code,
     * an optional message, and a type. If no message or type is provided,
     * default values are used.
     *
     * @param int    $statusCode the HTTP status code related to the exception, defaults to 500
     * @param string $message    the error message, defaults to an empty string
     * @param string $type       the type of the exception, defaults to a general exception type
     */
    public function __construct(
        string $message = ExceptionMessage::INTERNAL,
        int $statusCode = 500,
        string $type = ExceptionType::EXCEPTION
    ) {
        $this->type = $type;
        parent::__construct($message, $statusCode);
    }

    /**
     * Retrieves the type of the exception.
     *
     * @return string the type of the exception
     */
    public function getType(): string
    {
        return $this->type;
    }
}
