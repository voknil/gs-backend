<?php

namespace App\Response\User;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

final class GetUser
{
    public function __construct(
       private readonly User $user,
    )
    {
    }


    public function getId(): Uuid
    {
       return $this->user->getId();
    }

    public function getEmail():string{
        return $this->user->getEmail();
    }

    public function getFirstName():string{
        return $this->user->getFirstName();
    }

    public function getLastName():string{
        return $this->user->getLastName();
    }
}
