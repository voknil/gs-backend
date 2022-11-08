<?php

declare(strict_types=1);

namespace App\User\Domain\Command;

interface VerifyUserCommand
{
    public function getId(): ?string;

    public function getUri(): string;
}