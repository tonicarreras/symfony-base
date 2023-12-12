<?php

declare(strict_types=1);

namespace Home\Infrastructure\Adapter\Controller;

use Composer\InstalledVersions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{
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
            'currentTime' => $currentTime->format('Y-m-d H:i:s')
        ]);
    }
}