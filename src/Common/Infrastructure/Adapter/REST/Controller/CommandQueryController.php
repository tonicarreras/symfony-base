<?php

namespace Common\Infrastructure\Adapter\REST\Controller;

use Common\Application\Bus\Command\Command;
use Common\Application\Bus\Command\CommandBus;
use Common\Application\Bus\Query\Query;
use Common\Application\Bus\Query\QueryBus;
use Common\Application\Bus\Query\QueryResponse;
use Common\Application\Mediator\CommandQueryMediator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * The CommandQueryController class extends the AbstractController class provided by Symfony.
 * It also implements the CommandQueryMediator interface.
 * This class provides a unified interface for dispatching commands and queries in the context of a REST controller.
 * It encapsulates the dependencies on the CommandBus and QueryBus, and provides methods for dispatching commands and queries.
 */
class CommandQueryController extends AbstractController implements CommandQueryMediator
{
    /**
     * The constructor initializes the CustomController with a QueryBus and a CommandBus.
     *
     * @param QueryBus   $queryBus   the QueryBus to be used for dispatching queries
     * @param CommandBus $commandBus the CommandBus to be used for dispatching commands
     */
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus
    ) {
    }

    /**
     * The ask method dispatches a query using the QueryBus and returns the response.
     *
     * @param Query $query the query to be dispatched
     *
     * @return QueryResponse the response of the query execution
     */
    public function ask(Query $query): QueryResponse
    {
        return $this->queryBus->ask($query);
    }

    /**
     * The dispatch method dispatches a command using the CommandBus.
     * The method does not return a value.
     *
     * @param Command $command the command to be dispatched
     */
    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
