<?php

declare(strict_types=1);

namespace User\Infrastructure\Implementation\Persistence\ORM\Doctrine\Repository;

use Common\Infrastructure\Implementation\Persistence\ORM\Doctrine\DoctrineRepository;
use User\Domain\Model\User;
use User\Domain\Model\UserId;
use User\Domain\Model\Username;
use User\Domain\Repository\UserRepository;

readonly class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    /**
     * Find a user by username.
     *
     * This method will return a User entity that matches the given username.
     * If no user is found, it will return null.
     */
    public function findByUsername(Username $username): ?User
    {
        return $this->repository(User::class)->findOneBy(['username.value' => $username->value()]);
    }

    /**
     * Find a user by id.
     *
     * This method will return a User entity that matches the given id.
     * If no user is found, it will return null.
     */
    public function findById(UserId $id): ?User
    {
        return $this->repository(User::class)->find($id);
    }

    /**
     * Find all users.
     *
     * This method will return an array of all User entities.
     * If no users are found, it will return an empty array.
     *
     * @return User[]
     */
    public function findAll(): array
    {
        return $this->repository(User::class)->findAll();
    }

    /**
     * Save a user.
     *
     * This method will save the given User entity.
     *
     * @param User $user the User entity to be saved
     */
    public function save(User $user): void
    {
        $this->persist($user);
    }

    /**
     * Delete a user.
     *
     * This method will delete the given User entity from the database.
     *
     * @param User $user the User entity to be deleted
     */
    public function delete(User $user): void
    {
        $this->remove($user);
    }
}
