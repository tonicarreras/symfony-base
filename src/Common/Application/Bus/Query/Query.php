<?php

declare(strict_types=1);

namespace Common\Application\Bus\Query;

/**
 * The Query interface is a marker interface, which means it does not define any methods.
 * It is used to mark classes that should be treated as queries.
 * Queries are DTOs (Data Transfer Objects) that carry the intent of the user to retrieve something from the system.
 * Each query should be handled by exactly one query handler.
 */
interface Query
{
}
