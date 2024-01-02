<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\Security;

use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\ResourceNotFoundException;
use Common\Domain\Exception\ValidationException;
use Common\Domain\Validation\Trait\NotBlankValidationTrait;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use User\Domain\Model\Username;
use User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository\DoctrineUserRepository;

/**
 * Implements the UserProviderInterface for Symfony security,
 * providing methods to load and refresh User objects.
 *
 * @implements UserProviderInterface<UserAdapter>
 */
readonly class UserProvider implements UserProviderInterface
{
    use NotBlankValidationTrait;

    /**
     * @param DoctrineUserRepository $userRepository the user repository
     */
    public function __construct(
        private DoctrineUserRepository $userRepository
    ) {
    }

    /**
     * Loads a user by username.
     *
     * @param string $username the username to search for
     *
     * @return UserAdapter the loaded user
     *
     * @throws ResourceNotFoundException if the user is not found
     * @throws ValidationException       if the username is blank
     */
    public function loadUserByUsername(string $username): UserAdapter
    {
        if ($violation = $this->validateNotBlank($username, 'username')) {
            throw new ValidationException($violation);
        }

        $user = $this->userRepository->findByUsername(new Username($username));
        if (null === $user) {
            throw new ResourceNotFoundException();
        }

        return new UserAdapter($user);
    }

    /**
     * Refreshes the user for the account interface.
     *
     * @param UserInterface $user the user to refresh
     *
     * @return UserAdapter the refreshed user
     *
     * @throws UnsupportedUserException                      if the account is not supported
     * @throws ResourceNotFoundException|ValidationException if the user is not found
     */
    public function refreshUser(UserInterface $user): UserAdapter
    {
        if (!$user instanceof UserAdapter) {
            throw new UnsupportedUserException(ExceptionMessage::NOT_SUPPORTED);
        }

        $username = $user->getUserIdentifier();

        return $this->loadUserByUsername($username);
    }

    /**
     * Checks if the given class is supported by this provider.
     *
     * @param string $class the class to check
     *
     * @return bool whether the class is supported
     */
    public function supportsClass(string $class): bool
    {
        return UserAdapter::class === $class;
    }

    /**
     * Loads a user by their identifier.
     *
     * @param string $identifier the user identifier
     *
     * @return UserAdapter the loaded user
     *
     * @throws ResourceNotFoundException if the user is not found
     * @throws ValidationException       if the identifier is blank
     */
    public function loadUserByIdentifier(string $identifier): UserAdapter
    {
        return $this->loadUserByUsername($identifier);
    }
}
