<?php

namespace Common\Infrastructure\Bus\Event\MySql;

use Common\Domain\Bus\Event\DomainEvent;
use Common\Domain\Bus\Event\EventBus;
use Common\Domain\Utils\Trait\DateUtil;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

final class MySqlDoctrineEventBus implements EventBus
{
    use DateUtil;

    private const string DATABASE_TIMESTAMP_FORMAT = 'Y-m-d H:i:s';
    private readonly Connection $connection;

    /**
     * Constructor for MySqlDoctrineEventBus.
     *
     * @param EntityManager $entityManager the EntityManager instance
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    /**
     * Publishes the given domain events.
     *
     * @param DomainEvent ...$events The domain events to publish.
     *
     * @throws \Exception
     */
    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->publishEvent($event);
        }
    }

    /**
     * Publishes a single domain event.
     *
     * @param DomainEvent $domainEvent the domain event to publish
     *
     * @throws \Exception
     */
    private function publishEvent(DomainEvent $domainEvent): void
    {
        $id = $this->connection->quote($domainEvent->eventId());
        $aggregateId = $this->connection->quote($domainEvent->aggregateId());
        $name = $this->connection->quote($domainEvent::eventName());
        $body = $this->connection->quote(json_encode($domainEvent->toPrimitives(), JSON_THROW_ON_ERROR));
        $occurredOn = $this->connection->quote(
            self::stringToDate($domainEvent->occurredOn())->format(self::DATABASE_TIMESTAMP_FORMAT)
        );

        $this->connection->executeStatement(
            <<<SQL
                INSERT INTO domain_events (id, aggregate_id, name, body, occurred_on) 
                VALUES ($id, $aggregateId, $name, $body, $occurredOn);
            SQL
        );
    }
}
