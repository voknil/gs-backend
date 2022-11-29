<?php

declare(strict_types=1);

namespace App\Response\UserPasswordReset;

final class Request
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
