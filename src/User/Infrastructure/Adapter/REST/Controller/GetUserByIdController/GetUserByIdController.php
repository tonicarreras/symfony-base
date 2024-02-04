<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\GetUserByIdController;

use App\Common\Application\Exception\ValidationException;
use Common\Domain\Exception\ResourceNotFoundException;
use Common\Infrastructure\Adapter\Response\SuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use User\Application\Query\GetUserById\GetUserByIdQuery;
use User\Application\Query\GetUserById\GetUserByIdQueryHandler;

class GetUserByIdController
{
    /**
     * Retrieves a user by their uuid.
     *
     * @param string $id the Uuid of the user
     *
     * @return JsonResponse the response in JSON format
     * @throws ResourceNotFoundException|ValidationException
     */
    #[Route('/user/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke(string $id, GetUserByIdQueryHandler $handler): JsonResponse
    {
        $response = $handler(new GetUserByIdQuery($id));
        return SuccessResponse::get($response, 'get_user_by_id');
    }
}
