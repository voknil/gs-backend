<?php

namespace App\Controller;

use App\Exception\DomainException;
use App\Organization\QueryProcessor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class OrganizationController extends BaseController
{

    public function __construct(
        private readonly QueryProcessor $queryProcessor,
    )
    {
    }

    #[Route('/organization/{uuid}', name: 'app_organization_card', methods: ['GET'])]
    public function card(Uuid $uuid): Response
    {
        try {
            return $this->json($this->queryProcessor->get($uuid));
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }
}
