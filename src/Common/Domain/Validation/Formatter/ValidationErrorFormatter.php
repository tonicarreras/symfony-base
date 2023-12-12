<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Formatter;

class ValidationErrorFormatter
{
    /**
     * Formats a validation error.
     *
     * @return array the formatted validation error
     */
    public static function format(string $constraint, string $field, mixed $value): array
    {
        return [
            'constraint' => $constraint,
            'field' => $field,
            'value' => $value,
        ];
    }
}
