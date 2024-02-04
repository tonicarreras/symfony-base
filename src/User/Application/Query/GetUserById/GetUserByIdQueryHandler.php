<?php

declare(strict_types=1);

namespace User\Application\Query\GetUserById;

use App\Common\Application\Exception\ValidationException;
use Common\Application\Bus\Query\QueryHandler;
use Common\Domain\Exception\ResourceNotFoundException;
use User\Domain\Model\UserId;
use User\Domain\Repository\UserRepository;

/**
 * This class is responsible for handling the 'get user by ID' query, retrieving
 * user information based on their ID.
 */
final readonly class GetUserByIdQueryHandler implements QueryHandler
{
    /**
     * Constructor with UserRepository injection.
     *
     * @param UserRepository $userRepository user repository interface
     */
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    /**
     * Handles the 'get user by ID' query.
     *
     * @param GetUserByIdQuery $query the query object containing the user ID
     *
     * @return GetUserByIdResponse the response object with user details
     *
     * @throws ResourceNotFoundException thrown when the user is not found
     * @throws ValidationException
     */
    public function __invoke(GetUserByIdQuery $query): GetUserByIdResponse
    {
        $user = $this->userRepository->findById(new UserId($query->userId()));
        if (null === $user) {
            throw new ResourceNotFoundException();
        }

        return new GetUserByIdResponse(
            $user->id()->value(),
            $user->username()->value(),
            $user->roles()->value()
        );
    }
}
