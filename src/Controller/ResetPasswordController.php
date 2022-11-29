<?php

namespace App\Controller;

use App\Request\UserPasswordReset\Request;
use App\Request\UserPasswordReset\Reset;
use App\Security\UserPasswordResetterInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "public/user/reset-password/")]
class ResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordResetterInterface $userPasswordResetter,
    )
    {
    }

    #[Route('request', name: 'app_forgot_password_request', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Reset password request'
    )]
    public function request(Request $request): JsonResponse
    {
        return $this->json(
            $this->userPasswordResetter->request($request)
        );
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    #[Route('', name: 'app_reset_password', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Reset password with token'
    )]
    public function reset(Reset $request): Response
    {
        return $this->json(
            $this->userPasswordResetter->reset($request)
        );
    }
}
