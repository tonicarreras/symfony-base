<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\RegistrationController\DTO;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Represents the data transfer object for user registration requests.
 */
readonly class RegistrationRequestDto implements PasswordAuthenticatedUserInterface
{
    public function __construct(
        public ?string $username,
        public ?string $password,
        public ?array  $roles
    )
    {
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
