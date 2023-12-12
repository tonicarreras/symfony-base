<?php

declare(strict_types=1);

namespace Common\Domain\Exception;

use Common\Domain\Exception\Constant\ExceptionMessage;

/**
 * DuplicateValidationResourceException class for handling duplicate resource conflicts.
 *
 * This exception is thrown when an attempt is made to create or update a resource
 * that would result in a duplication, such as a unique constraint violation. It extends
 * the ApiException class, setting a specific HTTP status code (409 Conflict) and a
 * predefined error message indicating a duplication error.
 */
final class DuplicateValidationResourceException extends ApiException
{
    public const int STATUS_CODE = 409;

    /**
     * Constructor for the DuplicateValidationResourceException class.
     *
     * Initializes the exception with a 409 Conflict status code and a predefined
     * message indicating a duplicate resource error. The message is retrieved
     * from the ExceptionMessage constant.
     */
    public function __construct()
    {
        parent::__construct(self::STATUS_CODE, ExceptionMessage::DUPLICATE);
    }
}
