<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\DictionaryNotFound;
use App\Exception\UserLocaleNotSet;
use App\I18N\TranslationCommandProcessor;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class dictionaryController extends AbstractController
{

    private readonly TranslationCommandProcessor $commandProcessor;

    public function __construct(TranslationCommandProcessor $commandProcessor)
    {
        $this->commandProcessor = $commandProcessor;
    }

    #[Route('/dict/organization/types/', name: 'app_dictionary_organization_type_list', methods: ['GET'])]
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
        $locales = ['ООО', 'ИП'];
        $data = [
            'list' => array_map(function ($locale) {
                return $locale;
            }, $locales),
            'total' => count($locales)
        ];
        return $this->json($data);
    }


    #[Route('/dict/locale/', name: 'app_dictionary_locale_list', methods: ['GET'])]
    #[OA\Get(
        summary: "List of languages"
    )]
    #[OA\Tag(name: 'Dictionary')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'List of languages'
    )]
    public function getLocale(): JsonResponse
    {
        $locales = ['ru', 'en', 'es'];
        $data = [
            'list' => array_map(function ($locale) {
                return $locale;
            }, $locales),
            'total' => count($locales)
        ];
        return $this->json($data);
    }

    /**
     * @throws DictionaryNotFound
     */
    #[Route('/public/dict/translate/{dictionaryId}/{locale}', name: 'app_dictionary_translate', methods: ['GET'])]
    #[Route('/public/dict/translate/{dictionaryId}', name: 'app_dictionary_translate_no_locale', methods: ['GET'])]
    public function getTranslate(string $dictionaryId, ?string $locale): JsonResponse
    {
        if (empty($locale)) {
            $locale = 'ru';
        }
        return $this->json($this->commandProcessor->getTranslate($dictionaryId, $locale));
    }

}
