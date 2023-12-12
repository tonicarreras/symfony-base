<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;

use Common\Application\Bus\Command\Command;

/**
 * Command for creating a new user.
 *
 * This class serves as a data transfer object for user creation operations.
 * It encapsulates the necessary information (username, password, roles).
 */
final readonly class CreateUserCommand implements Command
{
    public function __construct(
        private string $username,
        private string $password,
        private ?array $roles
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }
}
