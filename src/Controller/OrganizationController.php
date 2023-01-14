<?php

namespace App\Controller;

use App\Exception\DomainException;
use App\Organization\Creator;
use App\Organization\QueryProcessor;
use App\Request\Organization\CreateOrganization;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class OrganizationController extends BaseController
{

    public function __construct(
        private readonly QueryProcessor $queryProcessor,
        private readonly Creator        $organizationCreator,
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

    #[Route('/organization/', name: 'app_organization_create', methods: ['POST'])]
    public function create(CreateOrganization $request): Response
    {
        try {
            return $this->json($this->organizationCreator->create($request));
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }

    #[Route('/organization/', name: 'app_organization_list', methods: ['GET'])]
    public function list(): Response
    {
        try {
            return $this->json($this->queryProcessor->getAll());
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }
}
