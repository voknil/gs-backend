<?php

namespace App\Organization;

use App\Entity\Organization;
use App\Exception\OrganizationAlreadyExists;
use App\Organization\Command\CreateOrganization;
use App\Repository\OrganizationRepository;
use App\Response\Organization\GetOrganization;
use Symfony\Component\Uid\Uuid;

final class Creator
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
    )
    {
    }

    /**
     * @throws OrganizationAlreadyExists
     */
    public function create(CreateOrganization $request): GetOrganization
    {
        $organization = Organization::create(
            Uuid::v4(),
            $request->getName(),
            $request->getAddress(),
            $request->getType(),
            $request->getWebsite(),
            $request->getDescription(),
            $request->getVk(),
            $request->getFacebook(),
            $request->getInstagram(),
            $request->getTelegram(),
        );
        $this->organizationRepository->add($organization);

        return new GetOrganization($organization);
    }
}
