<?php

namespace Common\Application\Mediator;

use Common\Application\Bus\Command\Command;
use Common\Application\Bus\Command\CommandBus;
use Common\Application\Bus\Query\Query;
use Common\Application\Bus\Query\QueryBus;
use Common\Application\Bus\Query\QueryResponse;

/**
 * The CommandQueryMediator class is an abstract class that provides a unified interface for dispatching commands and queries.
 * It encapsulates the dependencies on the CommandBus and QueryBus, and provides protected methods for dispatching commands and queries.
 * This class is intended to be extended by other classes that need to dispatch commands and queries.
 */
abstract readonly class CommandQueryMediator
{
    /**
     * The constructor initializes the CommandQueryMediator with a QueryBus and a CommandBus.
     *
     * @param QueryBus $queryBus The QueryBus to be used for dispatching queries.
     * @param CommandBus $commandBus The CommandBus to be used for dispatching commands.
     */
    public function __construct(
        private QueryBus   $queryBus,
        private CommandBus $commandBus,
    )
    {
    }

    /**
     * The ask method dispatches a query using the QueryBus and returns the response.
     *
     * @param Query $query The query to be dispatched.
     * @return QueryResponse The response of the query execution.
     */
    protected function ask(Query $query): QueryResponse
    {
        return $this->queryBus->ask($query);
    }

    /**
     * The dispatch method dispatches a command using the CommandBus.
     * The method does not return a value.
     *
     * @param Command $command The command to be dispatched.
     * @return void
     */
    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}