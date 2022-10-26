<?php

declare(strict_types=1);

namespace App\User\Domain\Command;

interface RecoverPasswordCommand
{
    public function getEmail(): string;
}