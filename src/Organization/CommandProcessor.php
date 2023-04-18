<?php

namespace App\Organization;

use App\Entity\Organization;
use App\Entity\User;
use App\Exception\OrganizationAlreadyExists;
use App\Exception\OrganizationNotFound;
use App\Exception\UserNotFound;
use App\Organization\Command\CreateOrganization;
use App\Organization\Command\UpdateOrganization;
use App\Persistence\Repository\UserRepository;
use App\Repository\OrganizationRepository;
use App\Request\User\Request;
use App\Response\Organization\GetOrganization;
use App\User\UserProfiler;
use Symfony\Component\Uid\Uuid;

final class CommandProcessor
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
        private readonly UserProfiler           $userProfiler,
        private readonly UserRepository         $userRepository,
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

    /**
     * @throws OrganizationNotFound
     */
    public function update(Uuid $uuid, UpdateOrganization $request): GetOrganization
    {
        $organization = $this->getOrganization($uuid);

        $organization->update(
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

        $this->organizationRepository->update($organization);

        return new GetOrganization($organization);
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

    /**
     * @throws OrganizationNotFound
     * @throws UserNotFound
     */
    public function addUserToOrganization(Uuid $uuidOrganization, Request $request): GetOrganization
    {
        $user = $this->getUser($request);

        $organization = $this->getOrganization($uuidOrganization);
        $organization->addUser($user);
        $this->organizationRepository->save($organization, true);

        return new GetOrganization($organization);
    }

    /**
     * @throws OrganizationNotFound
     * @throws UserNotFound
     */
    public function removeUserFromOrganization(Uuid $uuidOrganization, Request $request): GetOrganization
    {
        $user = $this->getUser($request);

        $organization = $this->getOrganization($uuidOrganization);
        $organization->removeUser($user);
        $this->organizationRepository->save($organization, true);

        return new GetOrganization($organization);
    }

    /**
     * @param Request $request
     * @return User
     * @throws UserNotFound
     */
    public function getUser(Request $request): User
    {
        $id = $request->getId();
        $user = $this->userRepository->get($id);

        if (null === $user) {
            throw new UserNotFound();
        }

        return $user;
    }
}
