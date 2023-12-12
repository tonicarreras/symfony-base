<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintType;
use Common\Domain\Validation\Formatter\ValidationErrorFormatter;

trait NotBlankValidationTrait
{
    /**
     * Validates that a string is not blank.
     *
     * @param string|null $value     the string to validate
     * @param string      $fieldName the name of the field for error messaging
     *
     * @return array an array containing a formatted validation error if the string is blank
     */
    public function validateNotBlank(?string $value, string $fieldName): array
    {
        if (empty($value)) {
            return ValidationErrorFormatter::format(
                ConstraintType::NOT_BLANK,
                $fieldName,
                $value
            );
        }

        return [];
    }
}
