<?php

declare(strict_types=1);

namespace User\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintType;
use Common\Domain\Validation\Formatter\ValidationErrorFormatter;
use User\Domain\Security\AllowedRoles;

/**
 * Provides methods for validating user roles.
 */
trait RolesValidationTrait
{
    /**
     * Validates an array of roles.
     *
     * @param string[] $roles array of roles to be validated
     *
     * @return array array of validation errors, if any
     */
    public function validateRoles(array $roles): array
    {
        $errors = [];

        foreach ($roles as $role) {
            if (!$this->isRoleValid($role)) {
                $errors[] = ValidationErrorFormatter::format(
                    'roles',
                    ConstraintType::INVALID,
                    $role
                );
            }
        }

        return $errors;
    }

    /**
     * Checks if a role is valid.
     *
     * @param string $role role to be validated
     *
     * @return bool returns true if the role is valid, false otherwise
     */
    protected function isRoleValid(string $role): bool
    {
        return in_array($role, AllowedRoles::getRoles(), true);
    }
}
