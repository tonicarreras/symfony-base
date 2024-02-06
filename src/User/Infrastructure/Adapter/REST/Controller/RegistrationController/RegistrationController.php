<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\RegistrationController;

use Common\Infrastructure\Adapter\Response\SuccessResponse;
use Common\Infrastructure\Adapter\REST\Controller\CommandQueryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Infrastructure\Adapter\REST\Controller\RegistrationController\DTO\RegistrationRequestDto;

class RegistrationController extends CommandQueryController
{
    /**
     * Handles the registration request.
     */
    #[Route('/register', name: 'register_user', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] RegistrationRequestDto $requestDTO,
        UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $password = $passwordHasher->hashPassword($requestDTO, $requestDTO->password);
        $this->dispatch(new CreateUserCommand($requestDTO->username, $password, $requestDTO->roles));

        return SuccessResponse::create('', 'register_user');
    }
}
