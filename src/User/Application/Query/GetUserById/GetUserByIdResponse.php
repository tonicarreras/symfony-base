<?php

declare(strict_types=1);

namespace User\Application\Query\GetUserById;

use Common\Application\Bus\Query\QueryResponse;

/**
 * This class represents the response data for a query to retrieve a user by their ID.
 * It includes the user's ID, username, and roles.
 */
final readonly class GetUserByIdResponse implements QueryResponse
{
    /**
     * Constructor for GetUserByIdResponse.
     *
     * @param string         $id       the unique identifier of the user
     * @param string         $username the username of the user
     * @param array|string[] $roles    the roles assigned to the user
     */
    public function __construct(
        public string $id,
        public string $username,
        public array $roles,
    ) {
    }
}
