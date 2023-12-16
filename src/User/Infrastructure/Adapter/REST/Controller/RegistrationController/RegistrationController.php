<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\RegistrationController;

use Common\Domain\Exception\DuplicateValidationResourceException;
use Common\Domain\Exception\ValidationException;
use Common\Infrastructure\Adapter\Response\SuccessResponse;
use Common\Infrastructure\Adapter\REST\Controller\CustomController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Domain\Validation\CreateUserValidator;
use User\Infrastructure\Adapter\REST\Controller\RegistrationController\DTO\RegistrationRequestDto;

class RegistrationController extends CustomController
{
    /**
     * Handles the registration request.
     *
     * @throws ValidationException
     * @throws DuplicateValidationResourceException
     */
    #[Route('/register', name: 'register_user', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] RegistrationRequestDto $requestDTO,
        CreateUserCommandHandler $handler,
        CreateUserValidator $validator,
        UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $validator->validateAndThrows($requestDTO);

        // PossiblyNullArgument is suppressed because the $requestDTO is validated in the CreateUserValidator
        /** @psalm-suppress PossiblyNullArgument */
        $password = $passwordHasher->hashPassword($requestDTO, $requestDTO->password);
        /** @psalm-suppress PossiblyNullArgument */
        $response = $handler(new CreateUserCommand($requestDTO->username, $password, $requestDTO->roles));

        return SuccessResponse::create($response);
    }
}
