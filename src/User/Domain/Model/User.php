<?php

declare(strict_types=1);

namespace User\Domain\Model;

use Common\Domain\Aggregate\AggregateRoot;
use Common\Domain\Exception\ValidationException;
use User\Domain\Event\UserCreatedDomainEvent;

/**
 * User class representing a user in the domain model.
 */
final class User extends AggregateRoot
{
    /**
     * Constructor for User.
     */
    private function __construct(
        private readonly UserId $id,
        private Username $username,
        private readonly string $password,
        private readonly UserRoles $roles
    ) {
    }

    /**
     * Static factory method to create a new User instance.
     *
     * @param UserId    $id       user's unique identifier
     * @param Username  $username user's username
     * @param string    $password user's password
     * @param UserRoles $roles    user's roles
     *
     * @return self returns an instance of User
     */
    public static function create(UserId $id, Username $username, string $password, UserRoles $roles): self
    {
        $user = new self($id, $username, $password, $roles);
        $user->record(new UserCreatedDomainEvent($id->value(), $username->value()));

        return $user;
    }

    /**
     * Get the user's Uuid.
     *
     * @return UserId user's Uuid
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * Get the user's username.
     *
     * @return Username user's username
     */
    public function username(): Username
    {
        return $this->username;
    }

    /**
     * Update the user's username.
     *
     * @param string $username new username
     *
     * @return static this instance for method chaining
     *
     * @throws ValidationException
     */
    public function updateUsername(string $username): User
    {
        $this->username = new Username($username);

        return $this;
    }

    /**
     * Get the user's roles.
     *
     * @return UserRoles user's roles
     */
    public function roles(): UserRoles
    {
        return $this->roles;
    }

    /**
     * Get the user's password.
     *
     * @return string user's password
     */
    public function password(): string
    {
        return $this->password;
    }
}
