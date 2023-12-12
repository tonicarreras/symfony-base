<?php

declare(strict_types=1);

namespace User\Application\Query\GetUserById;

use Common\Application\Bus\Query\Query;

/**
 * This class is used for handling the query to retrieve a user by their ID.
 */
final readonly class GetUserByIdQuery implements Query
{
    /**
     * Constructor for GetUserByIdQuery.
     *
     * @param string $userId the unique identifier of the user
     */
    public function __construct(
        public string $userId
    ) {
    }
}
