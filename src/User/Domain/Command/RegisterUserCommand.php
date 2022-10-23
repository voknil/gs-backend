<?php

declare(strict_types=1);

namespace App\User\Domain\Command;

use Symfony\Component\Uid\Uuid;

interface RegisterUserCommand
{
    public function getEmail(): string;

    public function getPassword(): string;
}