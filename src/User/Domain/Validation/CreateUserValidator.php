<?php

declare(strict_types=1);

namespace User\Domain\Validation;

use Common\Domain\Exception\ValidationException;
use Common\Domain\Validation\Trait\LengthValidationTrait;
use Common\Domain\Validation\Trait\NotBlankValidationTrait;
use Common\Domain\Validation\Trait\RangeValidationTrait;
use User\Domain\Validation\Trait\RolesValidationTrait;

/**
 * Validator for user creation. It ensures that all required fields meet the specified criteria.
 */
class CreateUserValidator
{
    use RangeValidationTrait;
    use RolesValidationTrait;
    use NotBlankValidationTrait;
    use LengthValidationTrait;

    private const int USERNAME_MIN_LENGTH = 4;
    private const int USERNAME_MAX_LENGTH = 20;
    private const int PASSWORD_MIN_LENGTH = 8;
    private const int PASSWORD_MAX_LENGTH = 255;

    /**
     * Validates the user object and throws a ValidationException if any violations are found.
     *
     * @param object $user the user object to validate
     *
     * @throws ValidationException if validation fails
     */
    public function validateAndThrows(object $user): void
    {
        $violations = array_merge(
            $this->validateStringField($user->username, 'username', self::USERNAME_MIN_LENGTH, self::USERNAME_MAX_LENGTH),
            $this->validateStringField($user->password, 'password', self::PASSWORD_MIN_LENGTH, self::PASSWORD_MAX_LENGTH),
            $this->validateRolesIfExists($user->roles ?? [])
        );

        if (!empty($violations)) {
            throw new ValidationException($violations);
        }
    }

    private function validateStringField(?string $value, string $fieldName, int $minLength, int $maxLength): array
    {
        return array_filter([
            $this->validateNotBlank($value, $fieldName),
            $this->validateLengthIfNotBlank($value, $minLength, $maxLength, $fieldName),
        ]);
    }

    private function validateRolesIfExists(array $roles): array
    {
        return empty($roles) ? [] : $this->validateRoles($roles);
    }

    private function validateLengthIfNotBlank(?string $value, int $min, int $max, string $fieldName): array
    {
        return empty($value) ? [] : $this->validateLength($value, $min, $max, $fieldName);
    }
}
