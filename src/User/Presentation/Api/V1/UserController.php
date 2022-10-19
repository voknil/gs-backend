<?php

namespace App\User\Presentation\Api\V1;

use App\User\Application\Command\GetUserProfile;
use App\User\Application\Exception\UserNotFound;
use App\User\Application\QueryProcessor;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/api/v1/user", name: "user_")]
class UserController extends AbstractController
{
    public function __construct(
        private readonly QueryProcessor $queryProcessor
    )
    {
    }

    #[Route('/{id}', name: 'profile', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the user profile'
    )]
    public function getUserProfile(string $id): JsonResponse
    {
        try {
            return $this->json(
                $this->queryProcessor->getUserProfile(new GetUserProfile($id))
            );
        } catch (UserNotFound $exception) {
            //TODO: Переделать на общий механизм исключений и переводов
            throw new NotFoundHttpException();
        }
    }
}
