<?php

declare(strict_types=1);

namespace User\Infrastructure\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Domain\Model\User;

/**
 * Adapts the domain User model to Symfony's UserInterface.
 * This adapter is used to integrate the domain User model with Symfony's security system.
 */
readonly class UserAdapter implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @param User $user the domain user model
     */
    public function __construct(
        private User $user
    ) {
    }

    /**
     * Returns the hashed password used to authenticate the user.
     *
     * @return string the hashed password
     */
    public function getPassword(): string
    {
        return $this->user->password();
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return string[] the user roles
     */
    public function getRoles(): array
    {
        return $this->user->roles()->value();
    }

    /**
     * Returns the identifier used to authenticate the user (e.g., username, email).
     *
     * @return string the user identifier
     */
    public function getUserIdentifier(): string
    {
        return $this->user->username()->value();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any point, sensitive information like the
     * plain password is stored on this object.
     */
    public function eraseCredentials(): void
    {
        // Implement this method to clear any sensitive data
    }
}
