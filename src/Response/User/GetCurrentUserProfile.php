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

    public function getCountry(): ?string
    {
        return $this->user->getCountry();
    }

    public function getCity(): ?string
    {
        return $this->user->getCity();
    }

    public function getPhone(): ?string
    {
        return $this->user->getPhone();
    }

    public function getAboutMe(): ?string
    {
        return $this->user->getAboutMe();
    }

    public function getVk(): ?string
    {
        return $this->user->getVk();
    }

    public function getFacebook(): ?string
    {
        return $this->user->getFacebook();
    }

    public function getInstagram(): ?string
    {
        return $this->user->getInstagram();
    }

    public function getTelegram(): ?string
    {
        return $this->user->getTelegram();
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
