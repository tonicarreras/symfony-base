<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintType;
use Common\Domain\Validation\Formatter\ValidationErrorFormatter;

trait NotNullValidationTrait
{
    /**
     * Validates that a value is not null.
     *
     * @param mixed  $value     the value to validate
     * @param string $fieldName the name of the field for error messaging
     *
     * @return array an array containing a formatted validation error if the value is null
     */
    public function validateNotNull(mixed $value, string $fieldName): array
    {
        if (is_null($value)) {
            return ValidationErrorFormatter::format(
                ConstraintType::NOT_NULL,
                $fieldName,
                $value
            );
        }

        return [];
    }
}
