<?php

namespace App\User\Presentation\Api\V1;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/api/v1/user", name: "user_")]
class UserController extends AbstractController
{
    #[Route('/{id}', name: 'profile', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the user profile'
    )]
    public function getUserProfile(string $id): JsonResponse
    {
        return $this->json('Hello');
    }
}
