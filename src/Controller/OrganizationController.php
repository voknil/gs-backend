<?php

namespace App\Controller;

use App\Exception\DomainException;
use App\Organization\CommandProcessor;
use App\Organization\QueryProcessor;
use App\Request\Organization\CreateOrganization;
use App\Request\Organization\UpdateOrganization;
use App\Request\User\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class OrganizationController extends BaseController
{

    public function __construct(
        private readonly QueryProcessor   $queryProcessor,
        private readonly CommandProcessor $commandProcessor,
    )
    {
    }

    #[Route('/organization/select/', name: 'app_organization_list_for_select', methods: ['GET'])]
    public function listForSelect(): Response
    {
        try {
            return $this->json($this->queryProcessor->getAllForSelect());
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }

    #[Route('/organization/{uuid}/join/', name: 'app_organization_join', requirements: ['uuid' => Requirement::UUID_V6], methods: ['PUT'])]
    public function join(Uuid $uuid): Response
    {
        try {
            $this->commandProcessor->join($uuid);
            return new Response();
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }

    #[Route('/organization/{uuid}', name: 'app_organization_card', requirements: ['uuid' => Requirement::UUID_V6], methods: ['GET'])]
    public function card(Uuid $uuid): Response
    {
        try {
            return $this->json($this->queryProcessor->get($uuid));
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

    #[Route('/organization/', name: 'app_organization_create', methods: ['POST'])]
    public function create(CreateOrganization $request): Response
    {
        try {
            return $this->json($this->commandProcessor->create($request));
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }

    #[Route('/organization/{uuid}', name: 'app_organization_update', requirements: ['uuid' => Requirement::UUID_V6], methods: ['PUT'])]
    public function update(Uuid $uuid, UpdateOrganization $request): Response
    {
        try {
            return $this->json($this->commandProcessor->update($uuid, $request));
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }
    #[Route('/organization/{uuid}/users', name: 'app_organization_users_list_for_command', methods: ['GET'])]
    public function organizationUsers(Uuid $uuid): Response
    {
        try {
            return $this->json($this->queryProcessor->getUsers($uuid));
        } catch (DomainException $exception) {
            return $this->json($exception);
        }
    }
}
