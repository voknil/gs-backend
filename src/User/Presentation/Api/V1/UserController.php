<?php

namespace App\User\Presentation\Api\V1;

use App\Core\Application\BaseController;
use App\User\Application\Command\GetUserProfile;
use App\User\Application\Command\RecoverPassword;
use App\User\Application\Command\RegisterUser;
use App\User\Application\CommandProcessor;
use App\User\Application\Exception\UserAlreadyExists;
use App\User\Application\Exception\UserNotFound;
use App\User\Application\QueryProcessor;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/api/v1/user", name: "user_")]
class UserController extends BaseController
{
    public function __construct(
        private readonly QueryProcessor   $queryProcessor,
        private readonly CommandProcessor $commandProcessor,
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
            throw $this->createNotFoundException();
        }
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Register user'
    )]
    public function registerUser(RegisterUser $command): JsonResponse
    {
        try {
            return $this->json(
                $this->commandProcessor->registerUser($command)
            );
        } catch (UserAlreadyExists $exception) {
            return $this->json($exception);
        }
    }

    #[Route('/recover-password', name: 'recover_password', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Recover password'
    )]
    public function recoverPassword(Request $request): JsonResponse
    {
        return $this->json(
            $this->commandProcessor->recoverPassword(new RecoverPassword($request->getContent()))
        );
    }
}
