<?php

namespace App\Controller;

use App\Exception\UserVerificationFailed;
use App\Registration\RegistrarInterface;
use App\Request\RegisterUser;
use App\Request\VerifyUser;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "public/register")]
class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly RegistrarInterface $registrar,
    )
    {
    }

    #[Route('/', name: 'app_register', methods: ['POST'])]
    #[OA\Tag(name: 'user')]
    #[OA\Response(
        response: 200,
        description: 'The user is registered successfully'
    )]
    #[OA\Response(
        response: 400,
        description: 'User already exists'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example:'{
              "email": "newuser5@test.com",
              "password": "Test1234",
              "locale": "ru"
            }'
        )
    )]
    public function registerUser(RegisterUser $request): JsonResponse
    {
        return $this->json($this->registrar->registerUser($request));
    }

    #[Route('/verify', name: 'app_register_verify', methods: ['GET'])]
    #[OA\Tag(name: 'user')]
    #[OA\Response(
        response: 200,
        description: 'User verification successfully'
    )]
    #[OA\Response(
        response: 400,
        description: 'User verification failed'
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Verification code',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    public function verifyUserEmail(VerifyUser $request): Response
    {
        try {
            $this->registrar->verifyUser($request);
        } catch (UserVerificationFailed $exception) {
        } finally {
            return $this->redirect('/');
        }
    }
}
