<?php

declare(strict_types=1);

namespace Common\Domain\Bus\Event;

/**
 * Interface for an event bus.
 * An event bus is a mechanism that handles the publishing and distribution of domain events across the system.
 * It allows different parts of the system to communicate with each other in a loosely coupled way by dispatching events that other parts can react to.
 */
interface EventBus
{
    /**
     * Publishes one or more domain events.
     * This method is responsible for dispatching the provided domain events to any interested subscribers.
     * The actual mechanism of how these events are delivered and processed can vary depending on the implementation.
     *
     * @param DomainEvent ...$events One or more domain event instances to be published.
     */
    public function publish(DomainEvent ...$events): void;
}
