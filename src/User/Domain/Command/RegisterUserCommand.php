<?php

declare(strict_types=1);

namespace App\User\Domain\Command;

interface RegisterUserCommand
{
    public function getEmail(): string;

    public function getPassword(): string;
}