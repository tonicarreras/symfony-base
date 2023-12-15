<?php

declare(strict_types=1);

namespace Common\Application\Bus\Query;

/**
 * The QueryResponse interface is a marker interface, which means it does not define any methods.
 * It is used to mark classes that should be treated as responses to queries.
 * Query responses are DTOs (Data Transfer Objects) that carry the result of a query execution.
 * Each query handler should return a QueryResponse.
 */
interface QueryResponse
{
}
