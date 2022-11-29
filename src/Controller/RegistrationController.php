<?php

namespace App\Controller;

use App\Exception\DomainException;
use App\Exception\UserVerificationFailed;
use App\Registration\RegistrarInterface;
use App\Request\RegisterUser;
use App\Request\VerifyUser;
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
