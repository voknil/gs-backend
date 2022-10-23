<?php

declare(strict_types=1);

namespace App\User\Application\Data;

use App\User\Domain\User;
use Symfony\Component\Uid\Uuid;

final class RegisterUserData
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