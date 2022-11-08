<?php

namespace App\User\Presentation\Api\V1;

use App\Core\Application\BaseController;
use App\User\Application\Command\GetUserProfile;
use App\User\Application\Command\RecoverPassword;
use App\User\Application\CommandProcessor;
use App\User\Application\Exception\UserNotFound;
use App\User\Application\QueryProcessor;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/api/v1/user", name: self::ROUTE_PREFIX)]
class UserController extends BaseController
{
    private const ROUTE_PREFIX = "user_";
    private const EMAIL_VERIFY_ROUTE = 'registration_confirmation_route';

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
