<?php

declare(strict_types=1);

namespace Common\Domain\Exception\Constant;

/**
 * ExceptionMessage class to hold constant messages for various exceptions.
 *
 * This class provides a centralized location for defining standard messages
 * associated with different types of exceptions. Using these constants ensures
 * consistency across the application when handling and reporting errors.
 */
class ExceptionMessage
{
    public const string INTERNAL = 'internal_error';
    public const string VALIDATION = 'validation';
    public const string NOT_FOUND = 'not_found';
    public const string DUPLICATE = 'duplicate';
    public const string NOT_SUPPORTED = 'not_supported';
    public const string INVALID_PAYLOAD = 'invalid_payload';
}
