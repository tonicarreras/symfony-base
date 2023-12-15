<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\GetUserByIdController;

use Common\Domain\Exception\ResourceNotFoundException;
use Common\Infrastructure\Adapter\Response\SuccessResponse;
use Common\Infrastructure\Adapter\REST\Controller\CustomController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdQuery;
use User\Application\Query\GetUserById\GetUserByIdQueryHandler;

class GetUserByIdController extends CustomController
{
    /**
     * Retrieves a user by their uuid.
     *
     * @param string $id the Uuid of the user
     *
     * @return JsonResponse the response in JSON format
     *
     * @throws ResourceNotFoundException
     */
    #[Route('/user/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke(string $id, GetUserByIdQueryHandler $handler): JsonResponse
    {
        $response = $handler->__invoke(new GetUserByIdQuery($id));

        return SuccessResponse::get($response);
    }
}
