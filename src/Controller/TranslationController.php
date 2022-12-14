<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\UserLocaleNotSet;
use App\Request\Translation\SetUserLocale;
use App\User\UserProfiler;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    public function __construct(
        private readonly UserProfiler $userProfiler,
    )
    {
    }

    #[Route('/translation/set-locale', name: 'app_user_set_locale', methods: ['PUT'])]
    #[OA\Put(
        summary: "Sets user locale",
    )]
    #[OA\Tag(name: 'user')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'User locale set successfully'
    )]
    #[OA\Response(
        response: 400,
        description: 'User locale not set'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example:'{
              "local": "en"
            }'
        )
    )]
    public function setUserLocale(SetUserLocale $request): Response
    {
        try {
            $this->userProfiler->updateUserLocale($request);
            return new Response();
        } catch (UserLocaleNotSet $exception) {
            return $this->json($exception);
        }
    }
}
