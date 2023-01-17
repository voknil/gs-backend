<?php

declare(strict_types=1);

namespace App\Response\User;

use App\Entity\Organization;
use App\Entity\User;
use App\Media\Storage\Storage;
use App\Media\Storage\StorageFile;
use App\Response\Organization\GetOrganizationForSelect;
use App\User\Enum\Gender;
use DateTimeImmutable;

final class GetCurrentUserProfile
{
    public function __construct(
        private readonly User    $user,
        private readonly Storage $mediaStorage,
    )
    {
    }

    public function getId(): string
    {
        return (string)$this->user->getId();
    }

    public function getLocale(): string
    {
        return $this->user->getLocale();
    }

    public function getEmail(): string
    {
        return $this->user->getEmail();
    }

    public function getFirstName(): ?string
    {
        return $this->user->getFirstName();
    }

    public function getLastName(): ?string
    {
        return $this->user->getLastName();
    }

    public function getGender(): ?Gender
    {
        return $this->user->getGender();
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->user->getBirthDate();
    }

    public function getImage(): ?StorageFile
    {
        $imageUuid = $this->user->getImageUuid();

        if (null === $imageUuid) {
            return null;
        }

        return $this->mediaStorage->getFileByUuid($imageUuid);
    }

    /**
     * @return array<GetOrganizationForSelect>
     */
    public function getOrganizations(): array
    {
        return $this->user
            ->getOrganizations()
            ->map(fn(Organization $organization) => new GetOrganizationForSelect($organization))
            ->toArray();
    }
}
