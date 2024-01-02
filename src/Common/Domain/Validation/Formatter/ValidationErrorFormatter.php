<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Formatter;

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
    public static function format(\Stringable|string $constraint, string $field, mixed $value): array
    {
        return [
            self::CONSTRAINT_KEY => $constraint,
            self::FIELD_KEY => $field,
            self::VALUE_KEY => $value,
        ];
    }
}
