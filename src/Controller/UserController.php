<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\User\GetCurrentUserProfile;
use App\User\UserProfiler;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    public function __construct(
        private readonly UserProfiler $userProfiler
    )
    {
    }

    #[Route('/user/profile/', name: 'app_user_profile_get', methods: ['GET'])]
    #[OA\Get(
        summary: "Gets current user profile",
    )]
    #[OA\Tag(name: 'user')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'Got user profile'
    )]
    public function getCurrentUserProfile(GetCurrentUserProfile $request): JsonResponse
    {
        return $this->json(
            $this->userProfiler->getCurrentUserProfile($request)
        );
    }
}
