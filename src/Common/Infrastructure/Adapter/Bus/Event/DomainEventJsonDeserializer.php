<?php

namespace Common\Infrastructure\Adapter\Bus\Event;

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
        if (!is_array($eventData) || !isset($eventData['data'])) {
            throw new \RuntimeException('Invalid event data format');
        }
        $data = $eventData['data'];
        if (!is_array($data) || !isset($data['type'], $data['attributes'], $data['id'], $data['occurred_on'])) {
            throw new \RuntimeException('Invalid event data format');
        }
        /** @var DomainEvent $eventClass */
        $eventClass = $this->mapping->for((string)$data['type']);

        if (is_array($data['attributes'])) {
            $id = isset($data['attributes']['id']) ? (string)$data['attributes']['id'] : '';
            $attributes = $data['attributes'];
            $eventId = $data['id'] ? (string)$data['id'] : '';
            $occurredOn = $data['occurred_on'] ? (string)$data['occurred_on'] : '';

            return $eventClass::fromPrimitives($id, $attributes, $eventId, $occurredOn);
        }

        throw new \RuntimeException('Invalid event data format');
    }
}
