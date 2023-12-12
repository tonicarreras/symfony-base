<?php

namespace Common\Infrastructure\Bus\Command\Symfony;

use Common\Application\Bus\Command\Command;
use Common\Application\Bus\Command\CommandBus;
use Common\Application\Bus\Exception\CommandNotRegisteredException;
use Common\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

/**
 * Implements CommandBus using Symfony's MessageBus for in-memory command handling.
 */
final readonly class InMemorySymfonyCommandBus implements CommandBus
{
    private MessageBus $bus;

    public function __construct(iterable $commandHandlers)
    {
        $this->bus = $this->initializeMessageBus($commandHandlers);
    }

    private function initializeMessageBus(iterable $commandHandlers): MessageBus
    {
        return new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forCallables($commandHandlers)
                    )
                ),
            ]
        );
    }

    /**
     * Dispatches a command.
     *
     * Dispatches the command to the message bus.
     * If no handler is found for the message, it throws a CommandNotRegisteredException.
     * If the handler fails, it throws the previous exception or the HandlerFailedException itself.
     *
     * @param Command $command the command to dispatch
     *
     * @throws \Throwable if the handler fails
     */
    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredException($command);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
