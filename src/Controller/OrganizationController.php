<?php

namespace App\Controller;

use App\Exception\OrganizationAlreadyExists;
use App\Exception\OrganizationNotFound;
use App\Exception\UserNotFound;
use App\Organization\CommandProcessor;
use App\Organization\QueryProcessor;
use App\Request\Organization\CreateOrganization;
use App\Request\Organization\UpdateOrganization;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class OrganizationController extends AbstractController
{

    public function __construct(
        private readonly QueryProcessor   $queryProcessor,
        private readonly CommandProcessor $commandProcessor,
    )
    {
    }

    #[Route('/organization/select/', name: 'app_organization_list_for_select', methods: ['GET'])]
    public function listForSelect(): JsonResponse
    {
        return $this->json($this->queryProcessor->getAllForSelect());
    }

    /**
     * @throws OrganizationNotFound
     * @throws UserNotFound
     */
    #[Route('/organization/{uuid}/join/', name: 'app_organization_join', requirements: ['uuid' => Requirement::UUID_V6], methods: ['PUT'])]
    public function join(Uuid $uuid): Response
    {
        $this->commandProcessor->join($uuid);
        return new Response();
    }

    /**
     * @throws OrganizationNotFound
     */
    #[Route('/organization/{uuid}', name: 'app_organization_card', requirements: ['uuid' => Requirement::UUID_V6], methods: ['GET'])]
    public function card(Uuid $uuid): JsonResponse
    {
        return $this->json($this->queryProcessor->get($uuid));
    }

    #[Route('/organization/', name: 'app_organization_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->json($this->queryProcessor->getAll());
    }

    /**
     * @throws OrganizationAlreadyExists
     */
    #[Route('/organization/', name: 'app_organization_create', methods: ['POST'])]
    public function create(CreateOrganization $request): JsonResponse
    {
        return $this->json($this->commandProcessor->create($request));
    }

    /**
     * @throws OrganizationNotFound
     */
    #[Route('/organization/{uuid}', name: 'app_organization_update', requirements: ['uuid' => Requirement::UUID_V6], methods: ['PUT'])]
    public function update(Uuid $uuid, UpdateOrganization $request): JsonResponse
    {
        return $this->json($this->commandProcessor->update($uuid, $request));
    }
}
