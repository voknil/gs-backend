<?php

declare(strict_types=1);

namespace App\User\Domain\Command;

use Symfony\Component\Uid\Uuid;

interface GetUserProfileCommand
{
    public function getId(): Uuid;
}