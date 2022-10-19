<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Command\GetUserProfileCommand;
use Symfony\Component\Uid\Uuid;

final class GetUserProfile implements GetUserProfileCommand
{
    public function __construct(
        private readonly string $id,
    )
    {
    }

    public function getId(): Uuid
    {
        return Uuid::fromString($this->id);
    }

}