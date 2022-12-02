<?php

declare(strict_types=1);

namespace App\Response\User;

use App\Entity\User;

final class GetCurrentUserProfile
{
    public function __construct(
        private readonly User $user,
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
}
