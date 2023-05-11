<?php

namespace App\Controller;

use App\Exception\OrganizationAlreadyExists;
use App\Exception\OrganizationNotFound;
use App\Exception\UserNotFound;
use App\Organization\CommandProcessor;
use App\Organization\QueryProcessor;
use App\Request\Organization\CreateOrganization;
use App\Request\Organization\PhotoGallery\UpdatePhotoGallery;
use App\Request\Organization\UpdateOrganization;
use App\Request\User\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
    #[OA\Get(
        summary: "Organization list for select"
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'Organization list'
    )]
    public function listForSelect(): JsonResponse
    {
        return $this->json($this->queryProcessor->getAllForSelect());
    }

    /**
     * @throws OrganizationNotFound
     * @throws UserNotFound
     */
    #[Route('/organization/{uuid}/join/', name: 'app_organization_join', requirements: ['uuid' => Requirement::UUID_V6], methods: ['PUT'])]
    #[OA\Put(
        summary: "join to organization",
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Parameter(
        name: "uuid",
        description: "UUID of the organization",
        in: "path",
        required: true
    )]
    #[OA\Response(
        response: 200,
        description: 'The user has been successfully joined to the organization'
    )]
    #[OA\Response(
        response: 404,
        description: 'Organization not found'
    )]
    public function join(Uuid $uuid): Response
    {
        $this->commandProcessor->join($uuid);
        return new Response();
    }

    /**
     * @throws OrganizationNotFound
     */
    #[Route('/organization/{uuid}', name: 'app_organization_card', requirements: ['uuid' => Requirement::UUID_V6], methods: ['GET'])]
    #[OA\Get(
        summary: "Get organization card"
    )]
    #[OA\Tag(name: 'organization')]
    #[OA\Parameter(
        name: "uuid",
        description: "UUID of the organization",
        in: "path",
        required: true
    )]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'All information about the organization'
    )]
    public function card(Uuid $uuid): JsonResponse
    {
        return $this->json($this->queryProcessor->get($uuid));
    }

    #[Route('/organization/', name: 'app_organization_list', methods: ['GET'])]
    #[OA\Get(
        summary: "Organization list"
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'Organization list'
    )]
    public function list(): JsonResponse
    {
        return $this->json($this->queryProcessor->getAll());
    }

    /**
     * @throws OrganizationAlreadyExists
     */
    #[Route('/organization/', name: 'app_organization_create', methods: ['POST'])]
    #[OA\Post(
        summary: "Create organization",
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Response(
        response: 200,
        description: 'Organization created successfully'
    )]
    #[OA\Response(
        response: 400,
        description: 'Organization already exists'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example: '{
                "name": "",
                "address": "г. Казань, Пушкина 46",
                "type": "ООО",
                "website": "http://test.org",
                "description": "Описание",
                "vk": "@oloolo",
                "facebook": "@ololoev",
                "instagram": "@vinnie",
                "telegram": "@thepooh"
            }'
        )
    )]
    public function create(CreateOrganization $request): JsonResponse
    {
        return $this->json($this->commandProcessor->create($request));
    }

    /**
     * @throws OrganizationNotFound
     */
    #[Route('/organization/{uuid}', name: 'app_organization_update', requirements: ['uuid' => Requirement::UUID_V6], methods: ['PUT'])]
    #[OA\Put(
        summary: "Update organization",
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Parameter(
        name: "uuid",
        description: "UUID of the organization",
        in: "path",
        required: true
    )]
    #[OA\Response(
        response: 200,
        description: 'Organization updated successfully'
    )]
    #[OA\Response(
        response: 404,
        description: 'Organization not found'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example: '{
                "name": "",
                "address": "г. Казань, Пушкина 46",
                "type": "ООО",
                "website": "http://test.org",
                "description": "Описание",
                "vk": "@oloolo",
                "facebook": "@ololoev",
                "instagram": "@vinnie",
                "telegram": "@thepooh"
            }'
        )
    )]
    public function update(Uuid $uuid, UpdateOrganization $request): JsonResponse
    {
        return $this->json($this->commandProcessor->update($uuid, $request));
    }

    /**
     * @throws OrganizationNotFound
     */
    #[Route('/organization/{uuid}/users', name: 'app_organization_users_list', methods: ['GET'])]
    #[OA\Get(
        summary: "Get organization users"
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Parameter(
        name: "uuid",
        description: "UUID of the organization",
        in: "path",
        required: true
    )]
    #[OA\Response(
        response: 200,
        description: 'Organization user list'
    )]
    #[OA\Response(
        response: 404,
        description: 'Organization not found'
    )]
    public function getUsersList(Uuid $uuid): Response
    {
        return $this->json($this->queryProcessor->getUsers($uuid));
    }


    /**
     * @throws OrganizationNotFound
     * @throws UserNotFound
     */
    #[Route('/organization/{uuid}/users', name: 'app_organization_add_user', methods: ['POST'])]
    #[OA\Post(
        summary: "Add user to organization"
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Parameter(
        name: "uuid",
        description: "UUID of the organization",
        in: "path",
        required: true
    )]
    #[OA\Response(
        response: 200,
        description: 'User added to organization'
    )]
    #[OA\Response(
        response: 404,
        description: 'Organization or user not found'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example: '{
                "id": "1eddad80-9fa1-609e-9cd7-f5b0fbdefe24"
            }'
        )
    )]
    public function addUserToOrganization(Uuid $uuid, Request $request): Response
    {
        return $this->json($this->commandProcessor->addUserToOrganization($uuid, $request));
    }

    /**
     * @throws OrganizationNotFound
     * @throws UserNotFound
     */
    #[Route('/organization/{uuid}/users', name: 'app_organization_remove_user', methods: ['DELETE'])]
    #[OA\Delete(
        summary: "Remove user from organization"
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Parameter(
        name: "uuid",
        description: "UUID of the organization",
        in: "path",
        required: true
    )]
    #[OA\Response(
        response: 200,
        description: 'User deleted from organization'
    )]
    #[OA\Response(
        response: 404,
        description: 'Organization or user not found'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example: '{
                "id": "1eddad80-9fa1-609e-9cd7-f5b0fbdefe24"
            }'
        )
    )]
    public function removeUserFromOrganization(Uuid $uuid, Request $request): Response
    {
        return $this->json($this->commandProcessor->removeUserFromOrganization($uuid, $request));
    }

    /**
     * @throws OrganizationNotFound
     */
    #[Route('/organization/{uuid}/media', name: 'app_organization_update_media_files', methods: ['PUT'])]
    #[OA\Put(
        summary: "Update organization photo gallery"
    )]
    #[OA\Tag(name: 'organization')]
    #[Security(name: 'Bearer')]
    #[OA\Parameter(
        name: "uuid",
        description: "UUID of the organization",
        in: "path",
        required: true
    )]
    #[OA\Response(
        response: 200,
        description: 'Photo gallery updated successfully'
    )]
    #[OA\Response(
        response: 404,
        description: 'Organization or user not found'
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(type: "object",
            example: '{
                "media": [
                    {
                        "id": "1ede449b-ed38-65b6-b556-212abf489108",
                        "mimeType": "image/png"
                    },
                    {
                        "id": "1ede4caa-774e-601e-859d-e16ce6512d67",
                        "mimeType": "video/mp4"
                    }
                ]
            }'
        )
    )]
    public function updateMediaFiles(Uuid $uuid, UpdatePhotoGallery $request): Response
    {
        $this->commandProcessor->updateMediaFiles($uuid, $request);
        return new Response();
    }
}
