<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event;

use Common\Domain\Bus\Event\DomainEventSubscriber;
use Common\Infrastructure\Bus\CallableFirstParameterExtractor;
use Common\Infrastructure\Bus\Event\RabbitMQ\Formatter\RabbitMqQueueNameFormatter;
use Traversable;

/**
 * Locator for domain event subscribers.
 * Responsible for locating event subscribers based on event types or queue names.
 * Utilizes a mapping of subscribers to identify relevant subscribers for given conditions.
 */
final class DomainEventSubscriberLocator
{
    private array $mapping;

    /**
     * Initializes the subscriber locator with an iterable mapping of event subscribers.
     * Converts the Traversable mapping to an array for internal use.
     *
     * @param \Traversable $mapping the iterable mapping of event subscribers
     */
    public function __construct(\Traversable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    /**
     * Retrieves all subscribers.
     *
     * @return array an array of all subscribers
     */
    public function all(): array
    {
        return $this->mapping;
    }
}
