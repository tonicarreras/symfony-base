<?php

declare(strict_types=1);

namespace Common\Domain\Aggregate;

use Common\Domain\Bus\Event\DomainEvent;

/**
 * AggregateRoot class representing the root of an aggregate in domain-driven design.
 * This class serves as a base for aggregate roots, providing functionalities to handle domain events.
 * It allows the aggregation of domain events and provides a mechanism to retrieve and clear these events.
 */
class AggregateRoot
{
    /**
     * @var DomainEvent[] array to store domain events
     */
    private array $domainEvents = [];

    /**
     * Retrieves and clears all recorded domain events.
     * This method returns the list of domain events recorded by the aggregate root and then resets the list.
     * Typically used for event publishing after a transaction is completed.
     *
     * @return DomainEvent[] the list of domain events
     */
    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    /**
     * Records a domain event.
     * Adds a given domain event to the list of events. These events can later be retrieved and published.
     */
    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
