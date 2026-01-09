<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HealthController 
{
    #[Route('/health', name: 'health', methods:['GET'])]
    public function __invoke(Connection $conn): JsonResponse
    {
       try {
            $conn->executeQuery('SELECT 1')->fetchOne();
            $db = 'ok';
        } catch (\Throwable) {
            $db = 'fail';
        }

        return new JsonResponse([
            'status' => 'ok',
            'db' => $db,
        ]);
    }
}
