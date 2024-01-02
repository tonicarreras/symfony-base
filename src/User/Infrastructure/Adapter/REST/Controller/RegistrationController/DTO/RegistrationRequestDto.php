<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\RegistrationController\DTO;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Represents the data transfer object for user registration requests.
 */
readonly class RegistrationRequestDto implements PasswordAuthenticatedUserInterface
{
    /**
     * Constructor for the class.
     *
     * @param string        $username the username for the user
     * @param string        $password the password for the user
     * @param string[]|null $roles    The roles assigned to the user. Can be null.
     */
    public function __construct(
        public string $username,
        public string $password,
        public ?array $roles
    ) {
    }

    /**
     * Gets the password.
     *
     * @return string|null the password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
