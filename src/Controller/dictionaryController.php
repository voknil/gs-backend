<?php
declare(strict_types=1);

namespace App\Controller;

use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "dict")]
class dictionaryController extends AbstractController
{
    #[Route('/organization/types/', name: 'app_dictionary_organization_type_list', methods: ['GET'])]
    #[OA\Get(
        summary: "Organization type list"
    )]
    #[OA\Tag(name: 'Dictionary')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'Organization type list'
    )]
    public function organizationTypeList(): JsonResponse
    {
        return $this->json(['ООО', 'ИП']);
    }

    #[Route('/local/', name: 'app_dictionary_local_list', methods: ['GET'])]
    #[OA\Get(
        summary: "List of languages"
    )]
    #[OA\Tag(name: 'Dictionary')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'List of languages'
    )]
    public function getLocal(): JsonResponse
    {
        return $this->json(['ru', 'en', 'es']);
    }
}
