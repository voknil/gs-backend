<?php

namespace App\Controller;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/api/v1/hello', name: 'api.hello', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the rewards of an user'
    )]
    public function test(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new hello controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }
}
