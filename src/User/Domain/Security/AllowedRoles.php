<?php

declare(strict_types=1);

namespace User\Domain\Security;

/**
 * This class defines a list of allowed roles within the system.
 */
readonly class AllowedRoles
{
    /**
     * An array of allowed roles.
     */
    public const array ALLOWED_ROLES = ['ROLE_ADMIN', 'ROLE_USER'];

    /**
     * Get the list of allowed roles.
     *
     * @return array an array of allowed roles
     */
    public static function getRoles(): array
    {
        return self::ALLOWED_ROLES;
    }
}
