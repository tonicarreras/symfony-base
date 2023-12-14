<?php

declare(strict_types=1);

namespace User\Domain\Model;

use Common\Domain\Aggregate\AggregateRoot;
use User\Domain\Event\CreateUserDomainEvent;

/**
 * User class representing a user in the domain model.
 */
class User extends AggregateRoot
{
    /**
     * Constructor for User.
     *
     * @param string $id       user's unique identifier
     * @param string $username user's username
     * @param string $password user's password
     * @param array  $roles    user's roles
     */
    public function __construct(
        private readonly string $id,
        private string $username,
        private string $password,
        private readonly array $roles
    ) {
    }

    /**
     * Static factory method to create a new User instance.
     *
     * @param string $id       user's unique identifier
     * @param string $username user's username
     * @param string $password user's password
     * @param array  $roles    user's roles
     *
     * @return self returns an instance of User
     */
    public static function create(string $id, string $username, string $password, array $roles): self
    {
        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }
        $user = new self($id, $username, $password, $roles);
        $user->record(new CreateUserDomainEvent($id, $username));

        return $user;
    }

    /**
     * Get the user's Uuid.
     *
     * @return string user's Uuid
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the user's username.
     *
     * @return string user's username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the user's username.
     *
     * @param string $username new username
     *
     * @return static this instance for method chaining
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the user's roles.
     *
     * @return array user's roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Get the user's password.
     *
     * @return string user's password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the user's password.
     *
     * @param string $password new password
     *
     * @return static this instance for method chaining
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
