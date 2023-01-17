<?php

namespace App\Organization;

use App\Entity\Organization;
use App\Entity\User;
use App\Exception\OrganizationNotFound;
use App\Exception\UserNotFound;
use App\Repository\OrganizationRepository;
use App\Response\Organization\GetOrganization;
use App\User\UserProfiler;
use Symfony\Component\Uid\Uuid;

final class Joiner
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
        private readonly UserProfiler           $userProfiler,
    )
    {
    }

    /**
     * @throws OrganizationNotFound
     * @throws UserNotFound
     */
    public function join(Uuid $uuid): GetOrganization
    {
        $organization = $this->getOrganization($uuid);

        $organization->addUser($this->getCurrentUser());
        $this->organizationRepository->save($organization, true);

        return new GetOrganization($organization);
    }

    /**
     * @throws OrganizationNotFound
     */
    private function getOrganization(Uuid $uuid): Organization
    {
        $organization = $this->organizationRepository->get($uuid);

        if (null === $organization) {
            throw new OrganizationNotFound();
        }

        return $organization;
    }

    /**
     * @throws UserNotFound
     */
    private function getCurrentUser(): User
    {
        $user = $this->userProfiler->getCurrentUser();

        if (null === $user) {
            throw new UserNotFound();
        }

        return $user;
    }
}
