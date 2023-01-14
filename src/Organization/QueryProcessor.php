<?php

namespace App\Organization;

use App\Exception\OrganizationNotFound;
use App\Repository\OrganizationRepository;
use App\Response\Organization\GetOrganization;
use App\Response\Organization\ListOrganization;
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
        $organization = $this->organizationRepository->get($uuid);

        if (null === $organization) {
            throw new OrganizationNotFound();
        }

        return new GetOrganization(
            $organization
        );
    }

    public function getAll(): ListOrganization
    {
        $organizationList = $this->organizationRepository->findAll();

        return new ListOrganization($organizationList);
    }
}
