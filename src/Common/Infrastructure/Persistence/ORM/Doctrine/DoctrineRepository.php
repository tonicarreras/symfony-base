<?php

namespace Common\Infrastructure\Persistence\ORM\Doctrine;

use Common\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class DoctrineRepository.
 *
 * This is an abstract class that provides basic functionality for a Doctrine repository.
 * It provides methods to persist and remove entities, and to get a repository for a specific entity class.
 */
abstract readonly class DoctrineRepository
{
    /**
     * DoctrineRepository constructor.
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Get the EntityManager instance.
     *
     * @return EntityManagerInterface the EntityManager instance
     */
    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * Persist an entity.
     * This method will persist the given entity and then flush the EntityManager.
     */
    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();
    }

    /**
     * Remove an entity.
     * This method will remove the given entity and then flush the EntityManager.
     */
    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    /**
     * Get a repository for a specific entity class.
     *
     * @template T of object
     *
     * @psalm-param class-string<T> $entityClass
     *
     * @psalm-return EntityRepository<T>
     */
    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }
}
