<?php

namespace App\Controller;

use App\Exception\DomainException;
use App\Exception\UserVerificationFailed;
use App\Registration\RegistrarInterface;
use App\Request\RegisterUser;
use App\Request\VerifyUser;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "public/register")]
class RegistrationController extends BaseController
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
        try {
            return $this->json($this->registrar->registerUser($request));
        } catch (DomainException $exception) {
            return $this->json(
                $exception
            );
        }
    }

    #[Route('/verify', name: 'app_register_verify', methods: ['GET'])]
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
