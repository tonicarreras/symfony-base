<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintType;
use Common\Domain\Validation\Formatter\ValidationErrorFormatter;

trait RangeValidationTrait
{
    /**
     * Validates that a value is within a specified range.
     *
     * @param float|int $value     the value to validate
     * @param float|int $min       the minimum allowed value
     * @param float|int $max       the maximum allowed value
     * @param string    $fieldName the name of the field for error messaging
     *
     * @return array an array containing a formatted validation error if the value is out of range
     */
    public function validateRange(float|int $value, float|int $min, float|int $max, string $fieldName): array
    {
        if ($value < $min || $value > $max) {
            return ValidationErrorFormatter::format(
                ConstraintType::RANGE,
                $fieldName,
                $value
            );
        }

        return [];
    }
}
