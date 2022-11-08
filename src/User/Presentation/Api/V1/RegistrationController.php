<?php

namespace App\User\Presentation\Api\V1;

use App\Core\Application\BaseController;
use App\Core\Application\DomainException;
use App\User\Application\Command\RegisterUser;
use App\User\Application\Command\VerifyUser;
use App\User\Application\CommandProcessor;
use App\User\Application\Exception\UserAlreadyExists;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/api/v1/registration", name: self::ROUTE_PREFIX)]
class RegistrationController extends BaseController
{
    private const ROUTE_PREFIX = "user_registration_";
    private const EMAIL_VERIFY_ROUTE = 'confirmation_route';

    public function __construct(
        private readonly CommandProcessor $commandProcessor,
    )
    {
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
                $this->commandProcessor->registerUser($command, self::ROUTE_PREFIX . self::EMAIL_VERIFY_ROUTE)
            );
        } catch (UserAlreadyExists $exception) {
            return $this->json($exception);
        }
    }

    #[Route('/verify', name: self::EMAIL_VERIFY_ROUTE, methods: ['GET'])]
    public function verifyUserEmail(VerifyUser $command): Response
    {
        try {
            $this->commandProcessor->verifyUser($command);
        } catch (DomainException $exception) {
            return $this->redirect('/'); //TODO: make redirect to error
        }

        return $this->redirect('/'); //TODO: make redirect to success
    }
}
