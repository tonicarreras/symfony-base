<?php

declare(strict_types=1);

namespace Common\Domain\Exception;

use Common\Domain\Exception\Constant\ExceptionMessage;

/**
 * ResourceNotFoundException class for handling "not found" scenarios.
 *
 * This exception should be thrown when a requested resource is not found in the system.
 * It extends the ApiException class, setting a specific HTTP status code (404 Not Found)
 * and a predefined error message indicating a resource not found error.
 */
final class ResourceNotFoundException extends ApiException
{
    public const int STATUS_CODE = 404;

    /**
     * Constructor for the ResourceNotFoundException class.
     *
     * Initializes the exception with a 404 Not Found status code and a predefined
     * message indicating a resource not found error. The message is retrieved
     * from the ExceptionMessage constant.
     */
    public function __construct()
    {
        parent::__construct(self::STATUS_CODE, ExceptionMessage::NOT_FOUND);
    }
}
