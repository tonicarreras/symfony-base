<?php

declare(strict_types=1);

namespace User\Domain\Event;

use Common\Domain\Bus\Event\DomainEvent;
use User\Domain\Model\Username;

/**
 * Domain event for when a user is created.
 *
 * This class extends the DomainEvent class, providing specifics for the user creation event.
 * It encapsulates all the necessary data and behaviors related to this event.
 */
readonly class UserCreatedDomainEvent extends DomainEvent
{
    /**
     * Constructor for UserCreatedDomainEvent.
     *
     * @param string      $id         the unique identifier for the event
     * @param string      $username   the username associated with the event
     * @param string|null $eventId    the event ID, if any
     * @param string|null $occurredOn the timestamp when the event occurred
     */
    public function __construct(
        string $id,
        private string $username,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    /**
     * Returns the event name.
     *
     * @return string the name of the event
     */
    public static function eventName(): string
    {
        return 'user.create';
    }

    /**
     * Factory method to create an instance from primitives.
     *
     * @param string $aggregateId the aggregate identifier
     * @param array  $body        the body of the event containing additional data
     * @param string $eventId     the event ID
     * @param string $occurredOn  the timestamp when the event occurred
     *
     * @return self the created domain event instance
     */
    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self {
        return new self($aggregateId, $body['username'], $eventId, $occurredOn);
    }

    /**
     * Serializes the event data to an array.
     *
     * @return array the serialized event data
     */
    public function toPrimitives(): array
    {
        return [
            'username' => $this->username,
        ];
    }

    /**
     * Gets the username associated with the event.
     *
     * @return string the username
     */
    public function username(): string
    {
        return $this->username;
    }
}
