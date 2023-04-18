<?php

declare(strict_types=1);

namespace App\Controller;

use App\Media\Storage\UploadLinkGenerator;
use App\Request\Media\GenerateUploadLinkRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "media")]
class MediaController extends AbstractController
{
    public function __construct(
        private readonly UploadLinkGenerator $uploadLinkGenerator,
    )
    {
    }

    #[Route('/generate-upload-link', name: 'app_media_generate_upload_link', methods: ['POST'])]
    public function registerUser(GenerateUploadLinkRequest $request): JsonResponse
    {
        return $this->json($this->uploadLinkGenerator->generate($request));
    }
}
