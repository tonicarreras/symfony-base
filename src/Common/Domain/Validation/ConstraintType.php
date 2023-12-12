<?php

declare(strict_types=1);

namespace Common\Domain\Validation;

/**
 * Class containing constants for various types of validation constraints.
 * These constants are used to specify the type of constraint being applied in validation error messages.
 */
class ConstraintType
{
    public const string REQUIRED = 'required';
    public const string LENGTH = 'length';
    public const string FORMAT = 'format';
    public const string NOT_BLANK = 'not_blank';
    public const string NOT_NULL = 'not_null';
    public const string RANGE = 'range';
    public const string INVALID = 'invalid';
}
