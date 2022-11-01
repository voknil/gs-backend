<?php

namespace App\User\Presentation\Api\V1;

use App\User\Application\Command\GetUserProfile;
use App\User\Application\Command\RecoverPassword;
use App\User\Application\Command\RegisterUser;
use App\User\Application\CommandProcessor;
use App\User\Application\Exception\UserNotFound;
use App\User\Application\QueryProcessor;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/api/v1/user", name: "user_")]
class UserController extends AbstractController
{
    public function __construct(
        private readonly QueryProcessor $queryProcessor,
        private readonly CommandProcessor $commandProcessor,
    )
    {
    }

    #[Route('/{id}', name: 'profile', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the user profile'
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        example: "1ed59c58-a12e-6f24-b064-1d66a1f32feb"
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


    #[Route('/register', name: 'register', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Register user'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example:'{
              "email": "newuser5@test.com",
              "password": "Test1234"
            }'
        )
    )]
    public function registerUser(Request $request): JsonResponse
    {
        //TODO: Сделать валидацию
        return $this->json(
            $this->commandProcessor->registerUser(new RegisterUser($request->getContent()))
        );
    }

    #[Route('/recover-password', name: 'recover_password', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Recover password'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example:'{"email": "newuser5@test.com"}'
        )
    )]
    public function recoverPassword(Request $request): JsonResponse
    {
        return $this->json(
            $this->commandProcessor->recoverPassword(new RecoverPassword($request->getContent()))
        );
    }
}
