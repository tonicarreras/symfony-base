<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\GetUserByIdController;

use Common\Infrastructure\Adapter\REST\Controller\CustomController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdQuery;
use User\Application\Query\GetUserById\GetUserByIdResponse;

class GetUserByIdController extends CustomController
{

    /**
     * Retrieves a user by their uuid.
     *
     * @param string $id the Uuid of the user
     *
     * @return JsonResponse the response in JSON format
     */
    #[Route('/api/user/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke(string $id): JsonResponse
    {
        /** @var GetUserByIdResponse $response */
        $response = $this->ask(new GetUserByIdQuery($id));

        return $this->json($response);
    }
}
