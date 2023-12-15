<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Bus\Event\Symfony\InMemory;

use Common\Domain\Bus\Event\DomainEvent;
use Common\Domain\Bus\Event\EventBus;
use Common\Infrastructure\Adapter\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

/**
 * In-memory implementation of the event bus using Symfony's Messenger component.
 * This class provides a mechanism for publishing domain events within the application
 * using Symfony's Messenger as the underlying message bus. It's designed for scenarios
 * where event handling is expected to occur synchronously and within the same process.
 */
class InMemorySymfonyEventBus implements EventBus
{
    private MessageBus $bus;

    /**
     * @param iterable $subscribers the iterable list of event subscribers
     */
    public function __construct(iterable $subscribers)
    {
        // Extracts the handlers for the subscribers and initializes the MessageBus.
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forCallables($subscribers)
                    )
                ),
            ]
        );
    }

    /**
     * Publishes domain events.
     * This method dispatches each provided domain event to the configured message bus,
     * where it will be handled by the appropriate subscriber.
     *
     * @param DomainEvent ...$events The domain events to publish.
     */
    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException) {
                // Ignore the exception if there's no handler for the event.
            }
        }
    }
}
