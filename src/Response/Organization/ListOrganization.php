<?php

namespace App\Response\Organization;

use App\Entity\Organization;

class ListOrganization
{
    /**
     * @param Organization[] $organizationList
     */
    public function __construct(
        private readonly array $organizationList,
    )
    {
    }

    /**
     * @return GetOrganization[]
     */
    public function getList(): array
    {
        return array_map(
            fn(Organization $organization): GetOrganization => new GetOrganization($organization),
            $this->organizationList
        );
    }

    public function getTotal(): int
    {
        return count($this->organizationList);
    }
}
