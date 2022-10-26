<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Command\GetUserProfileCommand;
use App\User\Domain\Command\RecoverPasswordCommand;
use App\User\Domain\Command\RegisterUserCommand;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;


final class RecoverPassword implements RecoverPasswordCommand
{
    #[Assert\Email]
    #[Assert\NotBlank]
    private ?string $email;

    public function __construct(
        #[Assert\Json]
        private readonly string $data,
    )
    {
        $jsonDataObject = json_decode($this->data);

        $this->email = $jsonDataObject?->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}