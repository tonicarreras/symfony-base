<?php

declare(strict_types=1);

namespace User\Domain\Repository;

use User\Domain\Model\User;
use User\Domain\Model\UserId;
use User\Domain\Model\Username;

/**
 * Interface for the user repository.
 * Defines the standard operations to be performed on User entities.
 */
interface UserRepository
{
    public function findById(UserId $id): ?User;

    public function findByUsername(Username $username): ?User;

    public function save(User $user): void;

    public function delete(User $user): void;

    public function findAll(): array;
}
