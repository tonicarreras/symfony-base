<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;

use Common\Application\Bus\Command\Command;

/**
 * Class CreateUserCommand.
 *
 * This class represents a command for creating a new user in the application. It implements the Command interface.
 * It encapsulates the necessary information for creating a user, such as username, password, and roles.
 */
final readonly class CreateUserCommand implements Command
{
    /**
     * CreateUserCommand constructor.
     *
     * Initializes a new instance of the CreateUserCommand class with the provided username, password, and roles.
     *
     * @param string        $username The username for the user
     * @param string        $password The password for the user
     * @param string[]|null $roles    The roles assigned to the user. Can be null.
     */
    public function __construct(
        private string $username,
        private string $password,
        private ?array $roles
    ) {
    }

    /**
     * Gets the username of the user.
     *
     * @return string The username of the user
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * Gets the password of the user.
     *
     * @return string The password of the user
     */
    public function password(): string
    {
        return $this->password;
    }

    /**
     * Gets the roles assigned to the user.
     *
     * @return string[]|null The roles assigned to the user, or null if no roles are assigned
     */
    public function roles(): ?array
    {
        return $this->roles;
    }
}
