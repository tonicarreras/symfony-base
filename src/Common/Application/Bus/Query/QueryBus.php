<?php

declare(strict_types=1);

namespace Common\Application\Bus\Query;

/**
 * The QueryBus interface defines a contract for a query bus.
 * A query bus is responsible for dispatching queries to their appropriate handlers.
 * It has a single method, ask, which takes a Query as an argument and returns a QueryResponse.
 * The ask method is responsible for finding the appropriate handler for the query and invoking it.
 */
interface QueryBus
{
    /**
     * Dispatches the given query to its appropriate handler.
     * The method returns a QueryResponse which contains the result of the query execution.
     *
     * @param Query $query the query to be dispatched
     *
     * @return QueryResponse the response of the query execution
     */
    public function ask(Query $query): QueryResponse;
}
