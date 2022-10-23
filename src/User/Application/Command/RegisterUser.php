<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\Command\GetUserProfileCommand;
use App\User\Domain\Command\RegisterUserCommand;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;


final class RegisterUser implements RegisterUserCommand
{
    #[Assert\Email]
    #[Assert\NotBlank]
    private ?string $email;

    #[Assert\NotBlank]
    private ?string $password;

    public function __construct(
        #[Assert\Json]
        private readonly string $data,
    )
    {
        $jsonDataObject = json_decode($this->data);

        $this->email = $jsonDataObject?->email;
        $this->password = $jsonDataObject?->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}