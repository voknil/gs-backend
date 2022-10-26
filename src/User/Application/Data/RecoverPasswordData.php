<?php

declare(strict_types=1);

namespace App\User\Application\Data;

final class RecoverPasswordData
{
    public function __construct(
        private readonly string $email,
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}