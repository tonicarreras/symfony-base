<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;

use Common\Application\Bus\Command\CommandHandler;
use Common\Domain\Exception\DuplicateValidationResourceException;
use Common\Domain\Exception\ValidationException;
use Common\Domain\ValueObject\Uuid;
use User\Domain\Model\UserId;
use User\Domain\Model\Username;
use User\Domain\Model\UserRoles;

/**
 * CreateUserCommandHandler handles the creation of new users.
 * Implements CommandHandler to integrate with command bus.
 */
final readonly class CreateUserCommandHandler implements CommandHandler
{
    /**
     * Constructor for CreateUserCommandHandler.
     *
     * @param UserCreator $creator the service responsible for creating new users
     */
    public function __construct(
        private UserCreator $creator
    ) {
    }

    /**
     * Invokes the command handler to process the CreateUserCommand.
     *
     * @param CreateUserCommand $command the command containing user creation data
     *
     * @return CreateUserResponse the response containing the ID of the created user
     *
     * @throws DuplicateValidationResourceException if a user with the same identifier already exists
     * @throws ValidationException
     */
    public function __invoke(CreateUserCommand $command): CreateUserResponse
    {
        // Create a new user with the provided details.
        // Return the response containing the new user's ID (Uuid).
        return new CreateUserResponse(
            $this->creator->__invoke(
                new UserId(Uuid::generateUuid()),
                new Username($command->username()),
                $command->password(),
                new UserRoles($command->roles() ?? [])
            )->id()->value());
    }
}
