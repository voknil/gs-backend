<?php
declare(strict_types=1);

namespace App\Request\User;

use App\Request\JsonValidatedRequest;
use Symfony\Component\Validator\Constraints as Assert;

final class Request extends JsonValidatedRequest
{
    #[Assert\Email]
    #[Assert\NotBlank]
    protected ?string $email;

    public function getEmail(): string
    {
        return $this->email;
    }
}
