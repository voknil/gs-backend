<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\DomainException;
use App\Exception\UserNotUpdated;
use App\Request\User\GetCurrentUserProfile;
use App\Request\User\UpdateCurrentUserProfile;
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
    #[OA\Response(
        response: 404,
        description: 'User not found'
    )]
    public function getCurrentUserProfile(GetCurrentUserProfile $request): JsonResponse
    {
        return $this->json(
            $this->userProfiler->getCurrentUserProfile($request)
        );
    }

    /**
     * @throws UserNotUpdated
     */
    #[Route('/user/profile/', name: 'app_user_profile_update', methods: ['PUT'])]
    public function updateCurrentUserProfile(UpdateCurrentUserProfile $request): JsonResponse
    {
        return $this->json(
            $this->userProfiler->updateCurrentUserProfile($request)
        );
    }
}
