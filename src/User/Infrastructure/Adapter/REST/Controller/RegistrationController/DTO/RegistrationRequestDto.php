<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\RegistrationController\DTO;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Represents the data transfer object for user registration requests.
 */
class RegistrationRequestDto implements PasswordAuthenticatedUserInterface
{
    public ?string $username = null;
    public ?string $password = null;
    public ?array $roles = null;

    /**
     * Gets the password.
     *
     * @return string|null the password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Sets the username.
     *
     * @param string|null $username the username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * Sets the password.
     *
     * @param string|null $password the password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * Sets the roles.
     *
     * @param array|null $roles the roles
     */
    public function setRoles(?array $roles): void
    {
        $this->roles = $roles;
    }
}
