<?php

namespace App\Response\Organization;

use App\Entity\Organization;
use Symfony\Component\Uid\Uuid;

final class GetOrganization
{
    public function __construct(
        private readonly Organization $organization,
    )
    {
    }

    public function getId(): Uuid
    {
        return $this->organization->getId();
    }

    public function getName(): string
    {
        return $this->organization->getName();
    }

    public function getAddress(): ?string
    {
        return $this->organization->getAddress();
    }

    public function getType(): ?string
    {
        return $this->organization->getType();
    }

    public function getWebsite(): ?string
    {
        return $this->organization->getWebsite();
    }

    public function getDescription(): ?string
    {
        return $this->organization->getDescription();
    }

    public function getVk(): ?string
    {
        return $this->organization->getVk();
    }

    public function getFacebook(): ?string
    {
        return $this->organization->getFacebook();
    }

    public function getInstagram(): ?string
    {
        return $this->organization->getInstagram();
    }

    public function getTelegram(): ?string
    {
        return $this->organization->getTelegram();
    }
}
