<?php

namespace App\Organization;

use App\Exception\OrganizationNotFound;
use App\Repository\OrganizationRepository;
use App\Response\Organization\GetOrganization;
use App\Response\Organization\ListOrganization;
use App\Response\Organization\ListOrganizationForSelect;
use App\Response\Organization\OrganizationUserList;
use Symfony\Component\Uid\Uuid;

final class QueryProcessor
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
    )
    {
    }

    /**
     * @throws OrganizationNotFound
     */
    public function get(Uuid $uuid): GetOrganization
    {
        $organization = $this->getOrganization($uuid);

        return new GetOrganization(
            $organization
        );
    }

    public function getAll(): ListOrganization
    {
        $organizationList = $this->organizationRepository->findAll();

        return new ListOrganization($organizationList);
    }

    public function getAllForSelect(): ListOrganizationForSelect
    {
        $organizationList = $this->organizationRepository->findAll();

        return new ListOrganizationForSelect($organizationList);
    }

    /**
     * @throws OrganizationNotFound
     */
    public function getUsers(Uuid $uuid): OrganizationUserList
    {
        $organization = $this->getOrganization($uuid);

        return new OrganizationUserList($organization->getUsers());

    }

    /**
     * @param Uuid $uuid
     * @return \App\Entity\Organization
     * @throws OrganizationNotFound
     */
    public function getOrganization(Uuid $uuid): \App\Entity\Organization
    {
        $organization = $this->organizationRepository->get($uuid);

        if (null === $organization) {
            throw new OrganizationNotFound();
        }
        return $organization;
    }


}
