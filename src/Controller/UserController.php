<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\DomainException;
use App\Request\User\GetCurrentUserProfile;
use App\Request\User\Request;
use App\Request\User\UpdateCurrentUserProfile;
use App\User\QueryProcessor;
use App\User\UserProfiler;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    public function __construct(
        private readonly UserProfiler   $userProfiler,
        private readonly QueryProcessor $queryProcessor,
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

    #[Route('/user/profile/', name: 'app_user_profile_update', methods: ['PUT'])]
    #[OA\Put(
        summary: "Update current user profile",
    )]
    #[OA\Tag(name: 'user')]
    #[OA\Response(
        response: 200,
        description: 'User profile updated successfully'
    )]
    #[OA\Response(
        response: 404,
        description: 'User not found'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example: '{
                "firstName": "testname",
                "lastName": "testlastname",
                "birthDate": "2022-12-25",
                "gender": "male",
                "country": "Россия",
                "city": "Владивосток",
                "locale": "ru",
                "phone": "+79990008877",
                "imageUuid": "18bee1c3-7469-42fe-b7ae-1c88645d6232",
                "aboutMe": "Я узнал, что у меня, есть огромная семья.",
                "vk": "vk.com/goodserfer",
                "facebook": "fb.com/goodserfer",
                "instagram": "@goodserfer",
                "telegram": "@goodserfer"
            }'
        )
    )]
    public function updateCurrentUserProfile(UpdateCurrentUserProfile $request): JsonResponse
    {
        try {
            return $this->json(
                $this->userProfiler->updateCurrentUserProfile($request)
            );
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }


    #[Route('/user/search', name: 'app_user_search', methods: ['GET'])]
    #[OA\Get(
        summary: "Search user",
    )]
    #[OA\Tag(name: 'user')]
    #[OA\Response(
        response: 200,
        description: 'Found user by email'
    )]
    #[OA\Response(
        response: 404,
        description: 'User not found'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example: '{
              "email": "admin@test.com"
            }'
        )
    )]
    public function findUser(Request $request): JsonResponse
    {
        try {
            return $this->json($this->queryProcessor->findUser($request));
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }
}
