<?php

declare(strict_types=1);

namespace Common\Application\Validation\Formatter;

class ValidationErrorFormatter
{
    public const string CONSTRAINT_KEY = 'constraint';
    public const string FIELD_KEY = 'field';
    public const string VALUE_KEY = 'value';

    /**
     * Formats a validation error.
     *
     * @return array the formatted validation error
     */
    public static function format(\Stringable|string $constraintKey, string $field, mixed $value): array
    {
        return [
            self::CONSTRAINT_KEY => $constraintKey,
            self::FIELD_KEY => $field,
            self::VALUE_KEY => $value,
        ];
    }
}
