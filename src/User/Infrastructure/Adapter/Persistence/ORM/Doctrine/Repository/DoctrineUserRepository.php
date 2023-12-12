<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepository;

/**
 * An implementation of UserRepository using Doctrine ORM for persistence.
 */
class DoctrineUserRepository implements UserRepository
{
    /** @var EntityRepository<User> */
    private EntityRepository $userRepository;

    /**
     * @param EntityManagerInterface $entityManager the Doctrine entity manager
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }

    public function findById(string $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }
}
