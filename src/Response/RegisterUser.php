<?php

declare(strict_types=1);

namespace App\Response;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

final class RegisterUser
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

    public function getEmail(): string
    {
        return $this->user->getEmail();
    }
}
