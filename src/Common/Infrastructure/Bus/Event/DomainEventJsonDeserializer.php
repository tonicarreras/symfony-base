<?php

namespace Common\Infrastructure\Bus\Event;

use Common\Domain\Bus\Event\DomainEvent;

/**
 * Responsible for deserializing domain event data from JSON to DomainEvent objects.
 */
final readonly class DomainEventJsonDeserializer
{
    /**
     * Initializes the deserializer with a mapping of event names to their corresponding classes.
     *
     * @param DomainEventMapping $mapping the mapping of event names to domain event classes
     */
    public function __construct(private DomainEventMapping $mapping)
    {
    }

    /**
     * Deserializes a JSON string into a DomainEvent object.
     *
     * @param string $domainEvent the JSON string representing the domain event
     *
     * @return DomainEvent the deserialized domain event
     *
     * @throws \JsonException if the JSON cannot be decoded or if the decoded data is not in the expected format
     */
    public function deserialize(string $domainEvent): DomainEvent
    {
        $eventData = json_decode($domainEvent, true, 512, JSON_THROW_ON_ERROR);
        $eventName = $eventData['data']['type'];
        $eventClass = $this->mapping->for($eventName);

        return $eventClass::fromPrimitives(
            $eventData['data']['attributes']['id'],
            $eventData['data']['attributes'],
            $eventData['data']['id'],
            $eventData['data']['occurred_on']
        );
    }
}
