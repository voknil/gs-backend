<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\UserLocaleNotSet;
use App\Request\Translation\SetUserLocale;
use App\Translation\UserLocaleUpdater;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    public function __construct(
        private readonly UserLocaleUpdater $userLocaleUpdater,
    )
    {
    }

    #[Route('/translation/set-locale', name: 'app_translation_set_user_locale', methods: ['PUT'])]
    #[OA\Put(
        summary: "Sets user locale",
    )]
    #[OA\Tag(name: 'user')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'User locale set successfully'
    )]
    public function setUserLocale(SetUserLocale $request): Response
    {
        try {
            return $this->json($this->userLocaleUpdater->updateUserLocale($request));
        } catch (UserLocaleNotSet $exception) {
            return $this->json($exception);
        }
    }
}
