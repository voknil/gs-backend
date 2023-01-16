<?php

namespace App\Response\Organization;

use App\Entity\Organization;
use Symfony\Component\Uid\Uuid;

final class GetOrganizationForSelect
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
}
