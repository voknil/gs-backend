<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Core\Application\JsonValidatedRequest;
use App\User\Domain\Command\RegisterUserCommand;
use Symfony\Component\Validator\Constraints as Assert;


final class RegisterUser extends JsonValidatedRequest implements RegisterUserCommand
{
    #[Assert\Email]
    #[Assert\NotBlank]
    protected ?string $email;

    #[Assert\NotBlank]
    protected ?string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}