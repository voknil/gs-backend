<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;


final class RegisterUser extends JsonValidatedRequest
{
    #[Assert\Email]
    #[Assert\NotBlank]
    protected ?string $email;

    #[Assert\NotBlank]
    protected ?string $password;

    #[Assert\NotBlank]
    protected ?string $locale;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }
}
