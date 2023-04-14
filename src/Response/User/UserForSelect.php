<?php
declare(strict_types=1);

namespace App\Response\User;

use App\Entity\User;

final class UserForSelect
{
    public function __construct(
        private readonly User    $user,
    )
    {
    }

    public function getId(): string
    {
        return (string)$this->user->getId();
    }

    public function getFirstName():string{
        return (string)$this->user->getFirstName();
    }

    public function getLastName():string{
        return (string)$this->user->getLastName();
    }

    public function getEmail():string{
        return (string)$this->user->getEmail();
    }
}
