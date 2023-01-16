<?php

namespace App\Response\Organization;

use App\Entity\Organization;

class ListOrganizationForSelect
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
            fn(Organization $organization): GetOrganizationForSelect => new GetOrganizationForSelect($organization),
            $this->organizationList
        );
    }

    public function getTotal(): int
    {
        return count($this->organizationList);
    }
}
