<?php

namespace Common\Infrastructure\Bus\Query\Symfony;

use Common\Application\Bus\Exception\QueryNotRegisteredException;
use Common\Application\Bus\Query\Query;
use Common\Application\Bus\Query\QueryBus;
use Common\Application\Bus\Query\QueryResponse;
use Common\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Implements QueryBus using Symfony's MessageBus for in-memory query handling.
 */
final readonly class InMemorySymfonyQueryBus implements QueryBus
{
    private MessageBus $bus;

    public function __construct(iterable $queryHandlers)
    {
        $this->bus = $this->initializeMessageBus($queryHandlers);
    }

    private function initializeMessageBus(iterable $queryHandlers): MessageBus
    {
        return new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    CallableFirstParameterExtractor::forCallables($queryHandlers)
                )
            ),
        ]);
    }

    /**
     * Asks a query and returns the response.
     *
     * Dispatches the query to the message bus and returns the result.
     * If no handler is found for the message, it throws a QueryNotRegisteredException.
     *
     * @param Query $query the query to ask
     *
     * @return QueryResponse the response to the query
     *
     * @throws QueryNotRegisteredException if no handler is found for the query
     */
    public function ask(Query $query): QueryResponse
    {
        try {
            /* @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);

            return $stamp ? $stamp->getResult() : throw new QueryNotRegisteredException($query);
        } catch (NoHandlerForMessageException) {
            throw new QueryNotRegisteredException($query);
        }
    }
}
