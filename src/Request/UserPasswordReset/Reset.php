<?php

declare(strict_types=1);

namespace App\Request\UserPasswordReset;

use App\Request\JsonValidatedRequest;
use Symfony\Component\Validator\Constraints as Assert;

final class Reset extends JsonValidatedRequest
{
    #[Assert\NotBlank]
    protected ?string $token;

    #[Assert\NotBlank]
    protected ?string $plainPassword;

    public function getToken(): string
    {
        return $this->token;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}
