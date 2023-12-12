<?php

declare(strict_types=1);

namespace Common\Domain\Exception\Constant;

/**
 * ExceptionType class to define constant values for various exception types.
 *
 * This class serves as a repository for defining different types of exceptions
 * in a consistent manner across the application. It helps in categorizing and
 * handling exceptions based on their types.
 */
class ExceptionType
{
    public const string EXCEPTION = 'exception';
    public const string VALIDATION = 'validation';
}
