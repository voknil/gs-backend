<?php

namespace App\Response\Organization;

use App\Entity\User;
use App\Response\ListResponse;
use App\Response\User\GetUser;
use Doctrine\Common\Collections\Collection;

class OrganizationUserList extends ListResponse
{
    /**
     * @param Collection<User> $userList
     */
    public function __construct(
        private readonly Collection $userList,
    )
    {
    }

    /**
     * @return GetUser[]
     */
    public function getUsers(): array
    {
        return $this->userList->map(fn(User $user): GetUser => new GetUser($user))->toArray();
    }

    public function getTotal(): int
    {
        return $this->userList->count();
    }
}
