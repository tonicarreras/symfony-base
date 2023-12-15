<?php

declare(strict_types=1);

namespace Home\Infrastructure\Adapter\REST\Controller;

use Composer\InstalledVersions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Attribute\Route;

/**
 * The HomeController class extends the AbstractController class provided by Symfony.
 * It defines a single action, __invoke, which is mapped to the '/' route.
 * The __invoke method returns a JsonResponse containing information about the project and the current time.
 */
class HomeController extends AbstractController
{
    /**
     * The __invoke method is the single action in this controller.
     * It is mapped to the '/' route and responds to GET requests.
     * The method retrieves information about the project from Composer and the current Symfony and PHP versions.
     * It also creates a new DateTimeImmutable object to get the current time.
     * All this information is returned as a JsonResponse.
     *
     * @return JsonResponse a JsonResponse containing information about the project and the current time
     */
    #[Route('/', name: 'home', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $kernel = Kernel::class;
        $symfonyVersion = $kernel::VERSION;

        $package = InstalledVersions::getRootPackage();
        $currentTime = new \DateTimeImmutable();

        return $this->json([
            'project_name' => $package['name'],
            'project_version' => $package['version'],
            'symfony_version' => $symfonyVersion,
            'php_version' => PHP_VERSION,
            'currentTime' => $currentTime->format('Y-m-d H:i:s'),
        ]);
    }
}
