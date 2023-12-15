<?php

namespace Common\Domain\Exception\Constant;

/**
 * Class ExceptionStatusCode
 *
 * This class defines constants for commonly used HTTP status codes in the context of exceptions.
 * These status codes can be associated with different types of exceptions to indicate the nature of the error.
 *
 * @package Common\Domain\Exception\Constant
 */
class ExceptionStatusCode
{
    public const int INTERNAL_ERROR = 500;

    public const int VALIDATION_ERROR = 422;

    public const int NOT_FOUND = 404;

    public const int DUPLICATE = 409;

    public const int NOT_SUPPORTED = 405;

    public const int INVALID_ARGUMENT = 400;
}
