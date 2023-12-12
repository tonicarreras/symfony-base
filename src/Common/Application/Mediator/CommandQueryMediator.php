<?php

namespace Common\Application\Mediator;

use Common\Application\Bus\Command\Command;
use Common\Application\Bus\Query\Query;
use Common\Application\Bus\Query\QueryResponse;

/**
 * The CommandQueryMediator interface defines a contract for a mediator between commands and queries.
 * It provides two methods: ask and dispatch.
 * The ask method is used to dispatch a query and return its response.
 * The dispatch method is used to dispatch a command.
 */
interface CommandQueryMediator
{
    /**
     * Dispatches the given query and returns its response.
     *
     * @param Query $query The query to be dispatched.
     * @return QueryResponse The response of the query execution.
     */
    public function ask(Query $query): QueryResponse;

    /**
     * Dispatches the given command.
     * The method does not return a value.
     *
     * @param Command $command The command to be dispatched.
     * @return void
     */
    public function dispatch(Command $command): void;
}