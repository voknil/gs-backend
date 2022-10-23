<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Command\GetUserProfileCommand;
use App\User\Domain\Command\RegisterUserCommand;
use Symfony\Component\Uid\Uuid;

final class RegisterUser implements RegisterUserCommand
{
    public function __construct(
        private readonly string $id,
    )
    {
    }

    public function getEmail(): string
    {
        // TODO: Implement getEmail() method.
    }

    public function getPassword(): string
    {
        // TODO: Implement getPassword() method.
    }


}